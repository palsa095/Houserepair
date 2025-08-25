@extends('layouts.app')

@section('title', 'Penyediaan Barang')

@section('content')
  <div class="rounded-lg bg-white p-4 shadow dark:bg-gray-800">
    {{-- Search and Filters --}}
    <div class="mb-4 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
        {{-- Search Input --}}
        <div class="relative">
          <input type="text" id="search" placeholder="Search..." class="block w-full rounded-lg border border-gray-300 bg-white p-2 pl-10 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white" value="{{ request('search') }}" wire:model.live="search">
        </div>

        {{-- Date Range Filter --}}
        <div class="flex items-center gap-2">
          <input type="date" id="startDate" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white" value="{{ request('start_date') }}">
          <span class="text-sm text-gray-500">to</span>
          <input type="date" id="endDate" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white" value="{{ request('end_date') }}">

          {{-- Apply Filter Button --}}
          <button id="applyFilter" class="flex items-center rounded-lg bg-indigo-600 p-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="fa-solid fa-filter mr-2"></i>
          </button>

          {{-- Reset Filter Button --}}
          <a href="{{ route('materials.index') }}" class="flex items-center rounded-lg bg-indigo-600 p-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="fa-solid fa-rotate-left mr-2"></i>
          </a>
        </div>
      </div>

      {{-- Action Buttons --}}
      <div class="flex gap-2">
        {{-- Print Button --}}
        <button onclick="printMaterialTable()" class="flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
          <i class="fa-solid fa-print mr-2"></i> Print
        </button>

        {{-- Add Material Button --}}
        <x-primary-button x-on:click="$dispatch('open-modal', 'createMaterial')">
          <i class="fa-solid fa-plus mr-2"></i>Tambah
        </x-primary-button>
      </div>
    </div>

    {{-- Table --}}
    @if ($materials->isEmpty())
      {{-- Empty State --}}
      <div class="rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 p-8 text-center dark:border-gray-600 dark:bg-gray-800">
        <i class="fa-solid fa-database text-5xl text-gray-400 dark:text-gray-500"></i>
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
            <a href="{{ route('materials.index') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
              <i class="fa-solid fa-filter-circle-xmark mr-2"></i> Reset Filter
            </a>
          @else
            <x-primary-button x-on:click="$dispatch('open-modal', 'createMaterial')">
              <i class="fa-solid fa-plus mr-2"></i>Tambah Material Pertama
            </x-primary-button>
          @endif
        </div>
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left text-sm" id="materialTable">
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
                    <button class="text-yellow-500 hover:text-yellow-700" @click="$dispatch('open-modal', 'editMaterial{{ $material->id }}')">
                      <i class="fa-solid fa-pen"></i>
                    </button>
                    <button class="text-red-500 hover:text-red-700" @click="$dispatch('open-modal', 'deleteMaterial{{ $material->id }}')">
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

  <script>
    function printMaterialTable() {
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
        .status-completed { background-color: #d1fae5; color: #065f46; }
        .status-processing { background-color: #fef3c7; color: #92400e; }
        .status-rejected { background-color: #fee2e2; color: #991b1b; }
      `);
      printWindow.document.write('</style>');
      printWindow.document.write('</head><body>');

      // Add header and date
      printWindow.document.write('<div class="header"><h2>Data Material</h2></div>');
      printWindow.document.write(`<div class="date">Printed on: ${new Date().toLocaleDateString('id-ID', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
      })}</div>`);

      // Get table data
      const table = document.createElement('table');
      const thead = document.createElement('thead');
      const tbody = document.createElement('tbody');

      // Create header row
      const headerRow = document.createElement('tr');
      ['No', 'Nama', 'Keterangan', 'Keperluan Barang', 'Total Harga'].forEach(text => {
        const th = document.createElement('th');
        th.textContent = text;
        headerRow.appendChild(th);
      });
      thead.appendChild(headerRow);
      table.appendChild(thead);

      // Create data rows
      @foreach ($materials as $i => $material)
        const row = document.createElement('tr');

        // Add cells
        [
          '{{ $i + 1 }}',
          '{{ $material->nama }}',
          '{{ $material->keterangan }}',
          '{{ $material->keperluan_barang }}',
          '{{ $material->total_harga }}',
        ].forEach((text, index) => {
          const td = document.createElement('td');
          if (index === 6) { // Status cell
            td.className = `status-${'{{ $material->status }}'.toLowerCase().replace(' ', '-')}`;
          }
          td.textContent = text;
          row.appendChild(td);
        });

        tbody.appendChild(row);
      @endforeach

      table.appendChild(tbody);
      printWindow.document.write(table.outerHTML);
      printWindow.document.write('</body></html>');
      printWindow.document.close();
      printWindow.focus();

      setTimeout(() => {
        printWindow.print();
        printWindow.close();
      }, 500);
    }

    // Filter functionality
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('search');
      const startDate = document.getElementById('startDate');
      const endDate = document.getElementById('endDate');
      const applyFilter = document.getElementById('applyFilter');

      // Apply filter when Enter is pressed in search input
      searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
          applyFilters();
        }
      });

      // Apply filter when button is clicked
      applyFilter.addEventListener('click', applyFilters);

      function applyFilters() {
        const params = new URLSearchParams();

        // Add search term if exists
        if (searchInput.value) {
          params.set('search', searchInput.value);
        }

        // Add date range if both dates are selected
        if (startDate.value && endDate.value) {
          params.set('start_date', startDate.value);
          params.set('end_date', endDate.value);
        }

        // Reload page with new filters
        window.location.href = `${window.location.pathname}?${params.toString()}`;
      }
    });
  </script>
@endsection
