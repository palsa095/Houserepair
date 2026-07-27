<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function home()
    {
        return view('pages.landing.home');
    }

    public function address()
    {
        $invoices = Invoice::query()
            ->where('user_id', auth()->id())
            ->latest('date')
            ->get();

        $names = $invoices->pluck('customer_name')->filter()->unique()->all();
        $customers = \App\Models\Customer::whereIn('name', $names)->orderBy('name')->get();
        if (auth()->check()) {
            $userCust = \App\Models\Customer::where('name', auth()->user()->name)->first();
            if ($userCust) {
                $customers = $customers->concat(collect([$userCust]))->unique('id')->values();
            }
        }
        $custIds = $customers->pluck('id')->all();

        $addresses = \App\Models\CustomerAddress::whereIn('customer_id', $custIds)
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        $fallback = (!$addresses->count() && $customers->count())
            ? $customers->pluck('address')->filter()->values()->all()
            : [];

        return view('pages.landing.address', [
            'addresses' => $addresses,
            'customers' => $customers,
            'fallback' => $fallback,
        ]);
    }

    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'label' => ['nullable', 'string', 'max:100'],
            'address_line' => ['required', 'string'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        $user = auth()->user();
        $customer = \App\Models\Customer::firstOrCreate(
            ['name' => $user->name],
            [
                'phone' => '',
                'address' => '',
                'category' => 'Sedang',
                'project' => null,
                'note' => null,
                'status' => 'Sedang diproses',
            ]
        );

        if (!empty($validated['is_default'])) {
            \App\Models\CustomerAddress::where('customer_id', $customer->id)->update(['is_default' => false]);
        }

        \App\Models\CustomerAddress::create([
            'customer_id' => $customer->id,
            'label' => $validated['label'] ?? null,
            'address_line' => $validated['address_line'],
            'is_default' => !empty($validated['is_default']),
        ]);

        return redirect()->back()->with('success', 'Alamat berhasil ditambahkan');
    }

    public function about()
    {
        return view('pages.landing.about');
    }

    public function order()
    {
        return view('pages.landing.order');
    }

    public function form()
    {
        $userName = auth()->check() ? auth()->user()->name : null;

        $addressOptions = [];
        $defaultAddressLine = null;
        if (auth()->check()) {
            $invoices = Invoice::query()
                ->where('user_id', auth()->id())
                ->latest('date')
                ->get();

            $names = $invoices->pluck('customer_name')->filter()->unique()->all();
            $customers = \App\Models\Customer::whereIn('name', $names)->get();
            $custIds = $customers->pluck('id')->all();

            if ($custIds) {
                $addrRows = \App\Models\CustomerAddress::whereIn('customer_id', $custIds)
                    ->orderBy('is_default', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->pluck('address_line')
                    ->all();
                if ($addrRows) {
                    $addressOptions = array_values(array_unique(array_filter($addrRows)));
                }
                $defaultRow = \App\Models\CustomerAddress::whereIn('customer_id', $custIds)
                    ->where('is_default', true)
                    ->orderBy('created_at', 'desc')
                    ->first();
                if ($defaultRow) {
                    $defaultAddressLine = $defaultRow->address_line;
                }
            }
            if (!$addressOptions) {
                $fallback = $customers->pluck('address')->filter()->values()->all();
                if ($fallback) {
                    $addressOptions = array_values(array_unique(array_filter($fallback)));
                }
            }
        }
        if (auth()->check() && !$addressOptions) {
            $userCust = \App\Models\Customer::where('name', auth()->user()->name)->first();
            if ($userCust) {
                $addrRows = \App\Models\CustomerAddress::where('customer_id', $userCust->id)
                    ->orderBy('is_default', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->pluck('address_line')
                    ->all();
                if ($addrRows) {
                    $addressOptions = array_values(array_unique(array_filter($addrRows)));
                }
                $defaultRow = \App\Models\CustomerAddress::where('customer_id', $userCust->id)
                    ->where('is_default', true)
                    ->orderBy('created_at', 'desc')
                    ->first();
                if ($defaultRow) {
                    $defaultAddressLine = $defaultRow->address_line;
                }
            }
        }

        return view('pages.landing.form', compact('userName', 'addressOptions', 'defaultAddressLine'));
    }

    public function invoice()
    {
        $invoices = Invoice::query()
            ->where('user_id', auth()->id())
            ->latest('date')
            ->with('items')
            ->get();

        $names = $invoices->pluck('customer_name')->filter()->unique()->all();
        $customers = \App\Models\Customer::whereIn('name', $names)->get()->keyBy('name');

        $materialsComplete = [];
        foreach ($invoices as $inv) {
            $cust = $customers[$inv->customer_name] ?? null;
            if (!$cust) {
                $materialsComplete[$inv->id] = false;
                continue;
            }
            $materialsComplete[$inv->id] = \App\Models\Material::where('customer_id', $cust->id)
                ->where('nama', '!=', '')
                ->where('keperluan_barang', '!=', '')
                ->where('total_harga', '>', 0)
                ->exists();
        }

        return view('pages.landing.invoice', compact('invoices', 'materialsComplete'));
    }

    public function showinvoice(Invoice $invoice)
    {
        $invoice->load('items');

        return view('pages.landing.show-invoice', compact('invoice'));
    }

    public function setDefaultAddress(\App\Models\CustomerAddress $address, Request $request)
    {
        $invoices = Invoice::query()
            ->where('user_id', auth()->id())
            ->latest('date')
            ->get();

        $names = $invoices->pluck('customer_name')->filter()->unique()->all();
        $customers = \App\Models\Customer::whereIn('name', $names)->get();
        $allowedIds = $customers->pluck('id')->all();
        if (auth()->check()) {
            $userCust = \App\Models\Customer::where('name', auth()->user()->name)->first();
            if ($userCust) {
                $allowedIds[] = $userCust->id;
            }
        }

        if (!in_array($address->customer_id, $allowedIds, true)) {
            abort(403);
        }

        \App\Models\CustomerAddress::where('customer_id', $address->customer_id)->update(['is_default' => false]);
        $address->is_default = true;
        $address->save();

        return redirect()->back()->with('success', 'Default address diperbarui');
    }
}
