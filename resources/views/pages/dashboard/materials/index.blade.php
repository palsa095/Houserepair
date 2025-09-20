@extends('layouts.app')

@section('title', 'Penyediaan Barang')

@section('content')
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

          {{-- Apply Filter Button --}}
          <button type="button" id="applyFilter"
                  class="flex items-center p-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="mr-2 fa-solid fa-filter"></i>
          </button>

          {{-- Reset Filter Button --}}
          <a href="{{ route('materials.index') }}"
             class="flex items-center p-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="mr-2 fa-solid fa-rotate-left"></i>
          </a>
        </div>
      </div>

      {{-- Action Buttons --}}
      <div class="flex gap-2">
        {{-- Print Button --}}
        <button type="button" id="printMaterialBtn"
                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
          <i class="mr-2 fa-solid fa-print"></i> Print
        </button>

        {{-- Add Material Button --}}
        <x-primary-button x-on:click="$dispatch('open-modal', 'createMaterial')">
          <i class="mr-2 fa-solid fa-plus"></i>Tambah
        </x-primary-button>
      </div>
    </div>

    {{-- Table --}}
    @if ($materials->isEmpty())
      {{-- Empty State --}}
      <div class="p-8 text-center border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 dark:border-gray-600 dark:bg-gray-800">
        <i class="text-5xl text-gray-400 fa-solid fa-database dark:text-gray-500"></i>
        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Data tidak tersedia</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
          @if (request()->hasAny(['search', 'status', 'start_date', 'end_date']))
            Tidak ada data yang cocok dengan filter Anda.
          @else
            Belum ada data material yang tersimpan.
          @endif
        </p>
        <div class="mt-6">
          @if (request()->hasAny(['search', 'status', 'start_date', 'end_date']))
            <a href="{{ route('materials.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
              <i class="mr-2 fa-solid fa-filter-circle-xmark"></i> Reset Filter
            </a>
          @else
            <x-primary-button x-on:click="$dispatch('open-modal', 'createMaterial')">
              <i class="mr-2 fa-solid fa-plus"></i>Tambah Material Pertama
            </x-primary-button>
          @endif
        </div>
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse" id="materialTable">
          <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
              <th class="p-2">#</th>
              <th class="p-2">Nama</th>
              <th class="p-2">Keterangan</th>
              <th class="p-2">Keperluan Barang</th>
              <th class="p-2">Total Harga</th>
              <th class="p-2">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($materials as $i => $material)
              <tr class="border-b dark:border-gray-600">
                <td class="p-2">{{ $i + 1 }}</td>
                <td class="p-2">{{ $material->nama }}</td>
                <td class="p-2">{{ $material->keterangan }}</td>
                <td class="p-2">{{ $material->keperluan_barang }}</td>
                <td class="p-2">{{ $material->total_harga }}</td>
                <td class="p-3 align-middle">
                  <div class="flex justify-center gap-2">
                    <button type="button" class="text-yellow-500 hover:text-yellow-700" @click="$dispatch('open-modal', 'editMaterial{{ $material->id }}')">
                      <i class="fa-solid fa-pen"></i>
                    </button>
                    <button type="button" class="text-red-500 hover:text-red-700" @click="$dispatch('open-modal', 'deleteMaterial{{ $material->id }}')">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      @if ($materials->hasPages())
        <div class="mt-4">
          {{ $materials->links() }}
        </div>
      @endif
    @endif
  </div>

  {{-- Include Modals --}}
  @include('pages.dashboard.materials.create')
  @foreach ($materials as $material)
    @include('pages.dashboard.materials.edit', ['material' => $material])
    @include('pages.dashboard.materials.delete', ['material' => $material])
  @endforeach
@endsection


@push('scripts')
<script>
  // ====== FILTER ======
  function applyMaterialFilters() {
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
    } catch (e) {
      console.error('applyMaterialFilters error:', e);
    }
  }

  // ====== PRINT ======
  function printMaterialTable() {
    try {
      const printWindow = window.open('', '', 'height=600,width=800');
      printWindow.document.write('<html><head><title>Data Material</title>');
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

      // Header & tanggal
      printWindow.document.write('<div class="header"><h2>Data Material</h2></div>');
      printWindow.document.write(`<div class="date">Printed on: ${new Date().toLocaleDateString('id-ID', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
      })}</div>`);

      // Buat tabel
      const table = document.createElement('table');
      const thead = document.createElement('thead');
      const tbody = document.createElement('tbody');

      const headerRow = document.createElement('tr');
      ['No', 'Nama', 'Keterangan', 'Keperluan Barang', 'Total Harga'].forEach(text => {
        const th = document.createElement('th');
        th.textContent = text;
        headerRow.appendChild(th);
      });
      thead.appendChild(headerRow);
      table.appendChild(thead);

      @foreach ($materials as $i => $material)
        (function() {
          const row = document.createElement('tr');
          const cells = [
            {{ $i + 1 }},
            @json($material->nama),
            @json($material->keterangan),
            @json($material->keperluan_barang),
            @json((string) $material->total_harga),
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

      setTimeout(() => {
        printWindow.print();
        printWindow.close();
      }, 300);
    } catch (e) {
      console.error('printMaterialTable error:', e);
    }
  }

  // ====== BIND HANDLERS ======
  function bindMaterialPageHandlers() {
    const btnFilter = document.getElementById('applyFilter');
    if (btnFilter) btnFilter.onclick = applyMaterialFilters;

    const inputSearch = document.getElementById('search');
    if (inputSearch) {
      inputSearch.onkeydown = (e) => { if (e.key === 'Enter') applyMaterialFilters(); };
    }

    const btnPrint = document.getElementById('printMaterialBtn');
    if (btnPrint) btnPrint.onclick = printMaterialTable;
  }

  // Ekspor global (opsional)
  window.applyMaterialFilters = applyMaterialFilters;
  window.printMaterialTable   = printMaterialTable;

  // Bind awal & setelah wire:navigate (Livewire v3)
  document.addEventListener('DOMContentLoaded', bindMaterialPageHandlers);
  document.addEventListener('livewire:navigated', bindMaterialPageHandlers);
</script>
@endpush
