<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Customer::query();

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
            'project' => 'required',
            'note' => 'nullable',
            'status' => 'nullable'
        ]);

        Customer::create($request->all());

        $userId = auth()->id();

        if (!$userId) {
            return redirect()->back()->withErrors('Anda harus login untuk membuat invoice');
        }

        Invoice::create([
            'user_id'       => $userId,
            'number'        => 'HR-' . now()->format('dmY') . rand(100000, 999999),
            'date'          => now(),
            'customer_name' => $request->name,
            'package'          => $request->package ?? 'Paket Besar',
            'project'          => $request->project ?? 'Reservasi',
        ]);

        return redirect()->back()->with('success', 'Berhasil membuat pesanan');
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
        $customer->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus pesanan');
    }
}
