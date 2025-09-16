<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::query()->with('items');

        if ($search = $request->string('search')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('project', 'like', "%{$search}%")
                    ->orWhere('package', 'like', "%{$search}%");
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->date('start_date'));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->date('end_date'));
        }

        $invoices = $query->latest('date')->paginate(10);

        return view('pages.dashboard.invoices.index', compact('invoices'));
    }

    public function store(InvoiceRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $request->validated();
            $total = collect($data['items'])->sum('subtotal');

            $invoice = Invoice::create([
                'number'           => $data['number'],
                'date'             => $data['date'],
                'customer_name'    => $data['customer_name'],
                'customer_address' => $data['customer_address'] ?? null,
                'customer_phone'   => $data['customer_phone'] ?? null,
                'package'          => $data['package'] ?? null,
                'project'          => $data['project'] ?? null,
                'currency'         => $data['currency'],
                'total'            => $total,
            ]);

            foreach ($data['items'] as $item) {
                $invoice->items()->create($item);
            }

            return redirect()->back()->with('success', 'Invoice dibuat.');
        });
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('items');
        return view('invoices.show', compact('invoice'));
    }

    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        return DB::transaction(function () use ($request, $invoice) {
            $data = $request->validated();
            $total = collect($data['items'])->sum('subtotal');

            $invoice->update([
                'number'           => $data['number'],
                'date'             => $data['date'],
                'customer_name'    => $data['customer_name'],
                'customer_address' => $data['customer_address'] ?? null,
                'customer_phone'   => $data['customer_phone'] ?? null,
                'package'          => $data['package'] ?? null,
                'project'          => $data['project'] ?? null,
                'currency'         => $data['currency'],
                'total'            => $total,
            ]);

            // Sinkronisasi items (hapus & buat ulang sederhana)
            $invoice->items()->delete();
            foreach ($data['items'] as $item) {
                $invoice->items()->create($item);
            }

            return redirect()->back()->with('success', 'Invoice diperbarui.');
        });
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice dihapus.');
    }
}
