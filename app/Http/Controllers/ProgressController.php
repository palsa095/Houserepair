<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Progress;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Progress::query();

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('yang_dikerjakan', 'like', '%' . $search . '%');
            });
        }

        // Date range filter
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        $progress = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('pages.dashboard.progress.index', compact('progress'));
    }

    public function store(Request $request)
    {
        // Hanya admin_progresor
        $validated = $request->validate([
            'nama' => 'required|string',
            'yang_dikerjakan' => 'required|string',
            'bukti_progress' => 'nullable'
        ]);

        // Support single & multiple file upload
        $bukti_progress = [];
        if ($request->hasFile('bukti_progress')) {
            $files = $request->file('bukti_progress');
            if (is_array($files)) {
                foreach ($files as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('progress', 'public');
                        $bukti_progress[] = $path;
                    }
                }
            } else {
                if ($files->isValid()) {
                    $path = $files->store('progress', 'public');
                    $bukti_progress[] = $path;
                }
            }
        }

        $progres = Progress::create([
            'nama' => $validated['nama'],
            'yang_dikerjakan' => $validated['yang_dikerjakan'],
            'bukti_progress' => $bukti_progress ? json_encode($bukti_progress) : null,
        ]);

        return redirect()->back()->with('success', 'Progress berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $progres = Progress::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'sometimes|string',
            'yang_dikerjakan' => 'sometimes|string',
            'bukti_progress' => 'nullable'
        ]);

        // Support single & multiple file upload
        $bukti_progress = $progres->bukti_progress ? json_decode($progres->bukti_progress, true) : [];
        if ($request->hasFile('bukti_progress')) {
            $files = $request->file('bukti_progress');
            if (is_array($files)) {
                foreach ($files as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('progress', 'public');
                        $bukti_progress[] = $path;
                    }
                }
            } else {
                if ($files->isValid()) {
                    $path = $files->store('progress', 'public');
                    $bukti_progress[] = $path;
                }
            }
        }

        $progres->update([
            'nama' => $validated['nama'] ?? $progres->nama,
            'yang_dikerjakan' => $validated['yang_dikerjakan'] ?? $progres->yang_dikerjakan,
            'bukti_progress' => $bukti_progress ? json_encode($bukti_progress) : null,
        ]);

        return redirect()->back()->with('success', 'Progress berhasil diperbarui');
    }

    public function destroy($id)
    {
        $progres = Progress::findOrFail($id);
        $progres->delete();

        return redirect()->back()->with('success', 'Progress berhasil dihapus');
    }
}
