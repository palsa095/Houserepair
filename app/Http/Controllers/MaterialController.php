<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Material;
use App\Models\Customer;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Material::query()->with('customer');

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('keperluan_barang', 'like', '%' . $search . '%')
                  ->orWhereHas('customer', function ($cq) use ($search) {
                      $cq->where('name', 'like', '%' . $search . '%')
                         ->orWhere('phone', 'like', '%' . $search . '%')
                         ->orWhere('address', 'like', '%' . $search . '%');
                  });
            });
        }

        // Date range filter
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        $materials = $query->orderBy('created_at', 'desc')->paginate(10);
        $customers = Customer::orderBy('name')->get();

        return view('pages.dashboard.materials.index', compact('materials', 'customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'nama' => 'required|string',
            'keterangan' => 'required|string',
            'keperluan_barang' => 'required|string',
            'total_harga' => 'required|numeric'
        ]);

        $validated['user_id'] = $request->user()->id;
        $material = Material::create($validated);

        return redirect()->back()->with('success', 'Material berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);
        $validated = $request->validate([
            'customer_id' => 'sometimes|exists:customers,id',
            'nama' => 'sometimes|string',
            'keterangan' => 'sometimes|string',
            'keperluan_barang' => 'sometimes|string',
            'total_harga' => 'sometimes|numeric'
        ]);

        $material->update($validated);

        return redirect()->back()->with('success', 'Material berhasil diperbarui');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->back()->with('success', 'Material berhasil dihapus');
    }
}
