<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Survey;
use App\Models\Customer;
use App\Models\Material;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Survey::query()->with('customer');

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('hasil_survey', 'like', '%' . $search . '%')
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

        $surveys = $query->orderBy('created_at', 'desc')->paginate(10);
        $customers = Customer::orderBy('name')->get();

        return view('pages.dashboard.surveys.index', compact('surveys', 'customers'));
    }

    public function store(Request $request)
    {
        // Hanya admin_surveyor
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'nama' => 'required|string',
            'hasil_survey' => 'required|string',
            'dokumentasi' => 'nullable'
        ]);

        // Support single & multiple file upload
        $dokumentasi = [];
        if ($request->hasFile('dokumentasi')) {
            $files = $request->file('dokumentasi');
            if (is_array($files)) {
                foreach ($files as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('surveys', 'public');
                        $dokumentasi[] = $path;
                    }
                }
            } else {
                if ($files->isValid()) {
                    $path = $files->store('surveys', 'public');
                    $dokumentasi[] = $path;
                }
            }
        }

        $survey = Survey::create([
            'user_id' => $request->user()->id,
            'customer_id' => $validated['customer_id'],
            'nama' => $validated['nama'],
            'hasil_survey' => $validated['hasil_survey'],
            'dokumentasi' => $dokumentasi ? json_encode($dokumentasi) : null,
        ]);

        if (trim($survey->nama) !== '' && trim($survey->hasil_survey) !== '') {
            $hasMaterial = Material::where('customer_id', $survey->customer_id)->exists();
            if (!$hasMaterial) {
                Material::create([
                    'user_id' => $request->user()->id,
                    'customer_id' => $survey->customer_id,
                    'nama' => '',
                    'keterangan' => null,
                    'keperluan_barang' => '',
                    'total_harga' => 0,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Survey berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $survey = Survey::findOrFail($id);
        $validated = $request->validate([
            'customer_id' => 'sometimes|exists:customers,id',
            'nama' => 'sometimes|string',
            'hasil_survey' => 'sometimes|string',
            'dokumentasi' => 'nullable'
        ]);

        // Support single & multiple file upload
        $dokumentasi = $survey->dokumentasi ? json_decode($survey->dokumentasi, true) : [];
        if ($request->hasFile('dokumentasi')) {
            $files = $request->file('dokumentasi');
            if (is_array($files)) {
                foreach ($files as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('surveys', 'public');
                        $dokumentasi[] = $path;
                    }
                }
            } else {
                if ($files->isValid()) {
                    $path = $files->store('surveys', 'public');
                    $dokumentasi[] = $path;
                }
            }
        }

        $survey->update([
            'nama' => $validated['nama'] ?? $survey->nama,
            'hasil_survey' => $validated['hasil_survey'] ?? $survey->hasil_survey,
            'customer_id' => $validated['customer_id'] ?? $survey->customer_id,
            'dokumentasi' => $dokumentasi ? json_encode($dokumentasi) : null,
        ]);

        $survey->refresh();
        if (trim($survey->nama) !== '' && trim($survey->hasil_survey) !== '') {
            $hasMaterial = Material::where('customer_id', $survey->customer_id)->exists();
            if (!$hasMaterial) {
                Material::create([
                    'user_id' => $request->user()->id,
                    'customer_id' => $survey->customer_id,
                    'nama' => '',
                    'keterangan' => null,
                    'keperluan_barang' => '',
                    'total_harga' => 0,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Survey berhasil diperbarui');
    }

    public function destroy($id)
    {
        $survey = Survey::findOrFail($id);
        $survey->delete();

        return redirect()->back()->with('success', 'Survey berhasil dihapus');
    }
}
