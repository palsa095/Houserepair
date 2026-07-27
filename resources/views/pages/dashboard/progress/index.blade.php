@extends('layouts.app')

@section('title', 'Pelaporan Progres')

@section('content')
  <style>
    .image-preview-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
      gap: 8px;
      margin-top: 8px;
    }
    .image-preview { position: relative; border-radius: 4px; overflow: hidden; width: 70px; }
    .image-preview img { width: 100%; height: 100%; object-fit: cover; }
    .image-count-badge {
      position: absolute; top: 4px; right: 4px;
      background-color: rgba(0,0,0,0.7); color: #fff; border-radius: 50%;
      width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 12px;
    }
    .dark .image-preview { border: 1px solid #374151; }
    .dark .image-count-badge { background-color: rgba(255,255,255,0.7); color: #1f2937; }
  </style>

  <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
    {{-- Search and Filters --}}
    <div class="flex flex-col gap-4 mb-4 md:flex-row md:items-center md:justify-between">
      <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
        {{-- Search Input --}}
        <div class="relative">
          <input
            type="text"
            id="search"
            placeholder="Search..."
            class="block w-full p-2 pl-10 text-sm bg-white border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            value="{{ request('search') }}"
            wire:model.live="search"
          >
        </div>

        {{-- Date Range Filter --}}
        <div class="flex items-center gap-2">
          <input type="date" id="startDate" class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-800 dark:text-white" value="{{ request('start_date') }}">
          <span class="text-sm text-gray-500">to</span>
          <input type="date" id="endDate" class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-800 dark:text-white" value="{{ request('end_date') }}">
        </div>

        <!-- Tombol filter -->
        <div class="flex gap-2">
          <button type="button" id="applyFilter"
                  class="flex items-center p-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="mr-2 fa-solid fa-filter"></i>
          </button>

          {{-- Reset Filter Button --}}
          <a href="{{ route('progress.index') }}"
             class="flex items-center p-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="mr-2 fa-solid fa-rotate-left"></i>
          </a>
        </div>
      </div>

      {{-- Action Buttons --}}
      <div class="flex gap-2">
        {{-- Print Button --}}
        <button type="button" id="printProgresBtn"
                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
          <i class="mr-2 fa-solid fa-print"></i> Print
        </button>

        {{-- Add Progres Button --}}
        @if(in_array(Auth::user()->role, ['admin_tukang', 'super_admin']))
        <x-primary-button x-on:click="$dispatch('open-modal', 'createProgres')">
          <i class="mr-2 fa-solid fa-plus"></i>Tambah
        </x-primary-button>
        @endif
      </div>
    </div>

    {{-- Table --}}
    @if ($progress->isEmpty())
      {{-- Empty State --}}
      <div class="p-8 text-center border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 dark:border-gray-600 dark:bg-gray-800">
        <i class="text-5xl text-gray-400 fa-solid fa-clipboard-list dark:text-gray-500"></i>
        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Data Progres Kosong</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Belum ada data progres yang tersimpan.</p>
        <div class="mt-6">
          @if(in_array(Auth::user()->role, ['admin_tukang', 'super_admin']))
          <x-primary-button x-on:click="$dispatch('open-modal', 'createProgres')">
            <i class="mr-2 fa-solid fa-plus"></i>Tambah Progres Pertama
          </x-primary-button>
          @endif
        </div>
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse" id="progresTable">
          <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
              <th class="p-2">#</th>
              <th class="p-2">Nama customer</th>
              <th class="p-2">alamat customerr</th>
              <th class="p-2">no phone customerr</th>
              <th class="p-2">Nama</th>
              <th class="p-2">Yang Dikerjakan</th>
              <th class="p-2">Bukti Progres</th>
              <th class="p-2">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($progress as $i => $progres)
              <tr class="border-b dark:border-gray-600">
                <td class="p-2">{{ $i + 1 }}</td>
                <td class="p-2">{{ $progres->customer->name ?? '-' }}</td>
                <td class="p-2">{{ $progres->customer->address ?? '-' }}</td>
                <td class="p-2">{{ $progres->customer->phone ?? '-' }}</td>
                <td class="p-2 font-medium">{{ $progres->nama }}</td>
                <td class="max-w-xs p-2 truncate">{{ $progres->yang_dikerjakan }}</td>
                <td class="p-3">
                  @if ($progres->bukti_progress)
                    @php
                      $images = json_decode($progres->bukti_progress, true) ?: [];
                      $count = count($images);
                    @endphp

                    <div x-data="{ showPreview: false }" class="relative">
                      <!-- Thumbnail dan jumlah foto -->
                      <div @click="showPreview = true" class="cursor-pointer">
                        <div class="image-preview">
                          <img src="{{ asset('storage/' . $images[0]) }}" alt="Preview bukti_progress">
                          @if ($count > 1)
                            <div class="image-count-badge">+{{ $count - 1 }}</div>
                          @endif
                        </div>
                      </div>

                      <!-- Modal preview semua gambar -->
                      <div x-show="showPreview" x-transition
                           class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-75"
                           @click.away="showPreview = false" x-trap.noscroll="showPreview">
                        <div class="relative max-h-[90vh] w-full max-w-4xl overflow-auto rounded-lg bg-white shadow-xl dark:bg-gray-800">
                          <button @click="showPreview = false"
                                  class="absolute text-gray-500 right-4 top-4 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100">
                            <i class="text-2xl fa-solid fa-xmark"></i>
                          </button>

                          <div class="p-6">
                            <h3 class="mb-4 text-lg font-semibold dark:text-white">Dokumentasi Progres</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                              @foreach ($images as $image)
                                <div class="overflow-hidden border rounded dark:border-gray-600">
                                  <img src="{{ asset('storage/' . $image) }}" alt="Dokumentasi progres" class="object-cover w-full h-48">
                                  <div class="p-2 text-center bg-gray-50 dark:bg-gray-700">
                                    <a href="{{ asset('storage/' . $image) }}" download class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                      <i class="mr-1 fa-solid fa-download"></i> Download
                                    </a>
                                  </div>
                                </div>
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  @else
                    <span class="text-gray-500">Tidak ada</span>
                  @endif
                </td>
                <td class="flex gap-2 p-2">
                  @if(in_array(Auth::user()->role, ['admin_tukang', 'super_admin']))
                  <button type="button" class="text-yellow-500 hover:text-yellow-700" @click="$dispatch('open-modal', 'editProgres{{ $progres->id }}')">
                    <i class="fa-solid fa-pen"></i>
                  </button>
                  <button type="button" class="text-red-500 hover:text-red-700" @click="$dispatch('open-modal', 'deleteProgres{{ $progres->id }}')">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      @if ($progress->hasPages())
        <div class="mt-4">
          {{ $progress->links() }}
        </div>
      @endif
    @endif
  </div>

  {{-- Include Modals --}}
  @include('pages.dashboard.progress.create')
  @foreach ($progress as $progres)
    @include('pages.dashboard.progress.edit', ['progres' => $progres])
    @include('pages.dashboard.progress.delete', ['progres' => $progres])
  @endforeach
@endsection


@push('scripts')
<script>
  // ====== FILTER ======
  function applyProgresFilters() {
    try {
      const searchInput = document.getElementById('search');
      const startDate   = document.getElementById('startDate');
      const endDate     = document.getElementById('endDate');

      const params = new URLSearchParams();
      if (searchInput && searchInput.value) params.set('search', searchInput.value);
      if (startDate && endDate && startDate.value && endDate.value) {
        params.set('start_date', startDate.value);
        params.set('end_date',   endDate.value);
      }

      window.location.href = `${window.location.pathname}?${params.toString()}`;
    } catch (e) { console.error('applyProgresFilters error:', e); }
  }

  // ====== PRINT ======
  function printProgresTable() {
    try {
      const printWindow = window.open('', '', 'height=600,width=800');
      printWindow.document.write('<html><head><title>Data Progres</title>');
      printWindow.document.write('<style>');
      printWindow.document.write(`
        body { font-family: Arial, sans-serif; margin: 1cm; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
        .date { text-align: right; margin-bottom: 10px; font-size: 0.9em; }
      `);
      printWindow.document.write('</style>');
      printWindow.document.write('</head><body>');

      // Header & Tanggal
      printWindow.document.write('<div class="header"><h2>Data Progres</h2></div>');
      printWindow.document.write(`<div class="date">Printed on: ${new Date().toLocaleDateString('id-ID', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
      })}</div>`);

      // Bangun tabel
      const table = document.createElement('table');
      const thead = document.createElement('thead');
      const tbody = document.createElement('tbody');

      const headerRow = document.createElement('tr');
      ['No', 'Nama Customer', 'Alamat', 'No. Telp', 'Nama', 'Yang Dikerjakan', 'Bukti Progres'].forEach(text => {
        const th = document.createElement('th');
        th.textContent = text;
        headerRow.appendChild(th);
      });
      thead.appendChild(headerRow);
      table.appendChild(thead);

      @foreach ($progress as $i => $progres)
        (function() {
          const row = document.createElement('tr');
          const cells = [
            {{ $i + 1 }},
            @json(optional($progres->customer)->name ?? '-'),
            @json(optional($progres->customer)->address ?? '-'),
            @json(optional($progres->customer)->phone ?? '-'),
            @json($progres->nama),
            @json($progres->yang_dikerjakan),
            @json($progres->bukti_progress ? (count(json_decode($progres->bukti_progress, true) ?: []) . ' foto') : 'Tidak ada'),
          ];
          cells.forEach(text => {
            const td = document.createElement('td');
            td.textContent = text;
            row.appendChild(td);
          });
          tbody.appendChild(row);
        })();
      @endforeach

      table.appendChild(tbody);
      printWindow.document.write(table.outerHTML);
      printWindow.document.write('</body></html>');
      printWindow.document.close();
      printWindow.focus();

      setTimeout(() => { printWindow.print(); printWindow.close(); }, 300);
    } catch (e) { console.error('printProgresTable error:', e); }
  }

  // ====== BIND HANDLERS ======
  function bindProgresPageHandlers() {
    const btnFilter = document.getElementById('applyFilter');
    if (btnFilter) btnFilter.onclick = applyProgresFilters;

    const inputSearch = document.getElementById('search');
    if (inputSearch) {
      inputSearch.onkeydown = (e)=>{ if (e.key === 'Enter') applyProgresFilters(); };
    }

    const btnPrint = document.getElementById('printProgresBtn');
    if (btnPrint) btnPrint.onclick = printProgresTable;
  }

  // Ekspor global (opsional)
  window.applyProgresFilters = applyProgresFilters;
  window.printProgresTable   = printProgresTable;

  // Bind awal & setelah wire:navigate (Livewire v3)
  document.addEventListener('DOMContentLoaded', bindProgresPageHandlers);
  document.addEventListener('livewire:navigated', bindProgresPageHandlers);
</script>
@endpush
