<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Survey;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Customer::query()->where('name', '!=', 'Alamat Tersimpan');

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%')
                    ->orWhere('note', 'like', '%' . $search . '%');
            });
        }

        // Status filter
        if ($status) {
            $query->where('status', $status);
        }

        // Date range filter
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        $customers = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('pages.dashboard.customers.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required',
            'category' => 'required',
            'project' => 'nullable',
            'note' => 'nullable',
            'status' => 'nullable'
        ]);

        $baseName = auth()->check() ? auth()->user()->name : $request->name;
        $customer = Customer::firstOrCreate(
            ['name' => $baseName],
            [
                'phone' => $request->phone,
                'address' => $request->address,
                'category' => $request->category,
                'project' => $request->project,
                'note' => $request->note,
                'status' => $request->status ?? 'Sedang diproses',
            ]
        );
        $customer->update([
            'phone' => $request->phone,
            'address' => $request->address,
            'category' => $request->category,
            'project' => $request->project,
            'note' => $request->note,
            'status' => $request->status ?? 'Sedang diproses',
        ]);

        $userId = auth()->id();

        if (!$userId) {
            return redirect()->back()->withErrors('Anda harus login untuk membuat invoice');
        }

        Invoice::create([
            'user_id'       => $userId,
            'number'        => 'HR-' . now()->format('dmY') . rand(100000, 999999),
            'date'          => now(),
            'customer_name' => $customer->name,
            'package'          => $request->package . ' - ' . $request->project ?? 'Paket Besar',
            'project'          => $request->project ?? 'Reservasi',
        ]);

        Survey::create([
            'user_id' => $userId,
            'customer_id' => $customer->id,
            'nama' => '',
            'hasil_survey' => '',
            'dokumentasi' => null,
        ]);

        return redirect()->route('landing.invoice')->with('success', 'Berhasil membuat pesanan');
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required',
            'category' => 'required',
            'note' => 'nullable',
            'status' => 'nullable'
        ]);

        $customer->update($request->all());

        return redirect()->back()->with('success', 'Berhasil mengedit pesanan');
    }

    public function destroy(Customer $customer)
    {
        $hasAddresses = \App\Models\CustomerAddress::where('customer_id', $customer->id)->exists();
        if ($hasAddresses) {
            $archive = Customer::firstOrCreate(
                ['name' => 'Alamat Tersimpan'],
                [
                    'phone' => '',
                    'address' => '',
                    'category' => 'Sedang',
                    'project' => null,
                    'note' => null,
                    'status' => 'Sedang diproses',
                ]
            );
            \App\Models\CustomerAddress::where('customer_id', $customer->id)->update(['customer_id' => $archive->id]);
        }
        $customer->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus customer');
    }
}
