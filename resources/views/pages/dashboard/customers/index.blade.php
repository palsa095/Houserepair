@extends('layouts.app')

@section('title', 'Data Customer')

@section('content')
  <div class="rounded-lg bg-white p-4 shadow dark:bg-gray-800">
    {{-- Search and Filters --}}
    <div class="mb-4 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
        {{-- Search Input --}}
        <div class="relative">
          <input type="text" id="search" placeholder="Search..." class="block w-full rounded-lg border border-gray-300 bg-white p-2 pl-10 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white" value="{{ request('search') }}" wire:model.live="search">
        </div>

        {{-- Status Filter (dipertahankan) --}}
        <div class="relative">
          <select id="statusFilter" class="rounded-lg border border-gray-300 bg-white px-3 py-2 pr-8 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
            <option value="">All Status</option>
            <option value="Sudah selesai" {{ request('status') === 'Sudah selesai' ? 'selected' : '' }}>Sudah selesai</option>
            <option value="Sedang diproses" {{ request('status') === 'Sedang diproses' ? 'selected' : '' }}>Sedang diproses</option>
            <option value="Tidak diterima" {{ request('status') === 'Tidak diterima' ? 'selected' : '' }}>Tidak diterima</option>
          </select>
        </div>

        {{-- Date Range Filter --}}
        <div class="flex items-center gap-2">
          <input type="date" id="startDate" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white" value="{{ request('start_date') }}">
          <span class="text-sm text-gray-500">to</span>
          <input type="date" id="endDate" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white" value="{{ request('end_date') }}">

          {{-- Apply Filter Button --}}
          <button type="button" id="applyFilter" class="flex items-center rounded-lg bg-indigo-600 p-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="fa-solid fa-filter mr-2"></i>
          </button>

          {{-- Reset Filter Button --}}
          <a href="{{ route('customers.index') }}" class="flex items-center rounded-lg bg-indigo-600 p-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="fa-solid fa-rotate-left mr-2"></i>
          </a>
        </div>
      </div>

      {{-- Action Buttons --}}
      <div class="flex gap-2">
        {{-- Print Button --}}
        <button type="button" id="printCustomerBtn" class="flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
          <i class="fa-solid fa-print mr-2"></i> Print
        </button>

        {{-- Add Customer Button --}}
        <x-primary-button x-on:click="$dispatch('open-modal', 'createCustomer')">
          <i class="fa-solid fa-plus mr-2"></i>Tambah
        </x-primary-button>
      </div>
    </div>

    {{-- Table --}}
    @if ($customers->isEmpty())
      {{-- Empty State --}}
      <div class="rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 p-8 text-center dark:border-gray-600 dark:bg-gray-800">
        <i class="fa-solid fa-database text-5xl text-gray-400 dark:text-gray-500"></i>
        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Data tidak tersedia</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
          @if (request()->hasAny(['search', 'status', 'start_date', 'end_date']))
            Tidak ada data yang cocok dengan filter Anda.
          @else
            Belum ada data customer yang tersimpan.
          @endif
        </p>
        <div class="mt-6">
          @if (request()->hasAny(['search', 'status', 'start_date', 'end_date']))
            <a href="{{ route('customers.index') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
              <i class="fa-solid fa-filter-circle-xmark mr-2"></i> Reset Filter
            </a>
          @else
            <x-primary-button x-on:click="$dispatch('open-modal', 'createCustomer')">
              <i class="fa-solid fa-plus mr-2"></i>Tambah Customer Pertama
            </x-primary-button>
          @endif
        </div>
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left text-sm" id="customerTable">
          <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
              <th class="p-2">#</th>
              <th class="p-2">Nama</th>
              <th class="p-2">No. Telp</th>
              <th class="p-2">Alamat</th>
              <th class="p-2">Kategori</th>
              <th class="p-2">Keterangan</th>
              <th class="p-2 text-center">Status</th>
              <th class="p-2">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($customers as $i => $customer)
              <tr class="border-b dark:border-gray-600">
                <td class="p-2">{{ $i + 1 }}</td>
                <td class="p-2">{{ $customer->name }}</td>
                <td class="p-2">{{ $customer->phone }}</td>
                <td class="p-2">{{ $customer->address }}</td>
                <td class="p-2">{{ $customer->category . ' - ' . $customer->project }}</td>
                <td class="p-2">{{ $customer->note }}</td>
                <td class="p-2 text-center">
                  <span
                    class="{{ $customer->status == 'Sudah selesai' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }} {{ $customer->status == 'Sedang diproses' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }} {{ $customer->status == 'Tidak diterima' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }} inline-flex items-center justify-center rounded-lg px-2 py-1 text-xs">
                    {{ $customer->status }}
                  </span>
                </td>
                <td class="p-3 align-middle">
                  <div class="flex justify-center gap-2">
                    <button type="button" class="text-yellow-500 hover:text-yellow-700" @click="$dispatch('open-modal', 'editCustomer{{ $customer->id }}')">
                      <i class="fa-solid fa-pen"></i>
                    </button>
                    <button type="button" class="text-red-500 hover:text-red-700" @click="$dispatch('open-modal', 'deleteCustomer{{ $customer->id }}')">
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
      @if ($customers->hasPages())
        <div class="mt-4">
          {{ $customers->links() }}
        </div>
      @endif
    @endif
  </div>

  {{-- Include Modals --}}
  @include('pages.dashboard.customers.create')
  @foreach ($customers as $customer)
    @include('pages.dashboard.customers.edit', ['customer' => $customer])
    @include('pages.dashboard.customers.delete', ['customer' => $customer])
  @endforeach
@endsection

@push('scripts')
  <script>
    // ====== FILTER ======
    function applyCustomerFilters() {
      try {
        const searchInput = document.getElementById('search');
        const statusFilter = document.getElementById('statusFilter');
        const startDate = document.getElementById('startDate');
        const endDate = document.getElementById('endDate');

        const params = new URLSearchParams();
        if (searchInput && searchInput.value) params.set('search', searchInput.value);
        if (statusFilter && statusFilter.value) params.set('status', statusFilter.value);
        if (startDate && endDate && startDate.value && endDate.value) {
          params.set('start_date', startDate.value);
          params.set('end_date', endDate.value);
        }

        window.location.href = `${window.location.pathname}?${params.toString()}`;
      } catch (e) {
        console.error('applyCustomerFilters error:', e);
      }
    }

    // ====== PRINT ======
    function printCustomerTable() {
      try {
        const printWindow = window.open('', '', 'height=600,width=800');
        printWindow.document.write('<html><head><title>Data Customer</title>');
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
        printWindow.document.write('<div class="header"><h2>Data Customer</h2></div>');
        printWindow.document.write(`<div class="date">Printed on: ${new Date().toLocaleDateString('id-ID', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
      })}</div>`);

        // Buat tabel
        const table = document.createElement('table');
        const thead = document.createElement('thead');
        const tbody = document.createElement('tbody');

        const headerRow = document.createElement('tr');
        ['No', 'Nama', 'No. Telp', 'Alamat', 'Kategori', 'Keterangan', 'Status'].forEach(text => {
          const th = document.createElement('th');
          th.textContent = text;
          headerRow.appendChild(th);
        });
        thead.appendChild(headerRow);
        table.appendChild(thead);

        @foreach ($customers as $i => $customer)
          (function() {
            const row = document.createElement('tr');
            const cells = [
              {{ $i + 1 }},
              @json($customer->name),
              @json($customer->phone),
              @json($customer->address),
              @json($customer->category . ' - ' . $customer->project),
              @json($customer->note),
              @json($customer->status),
            ];
            cells.forEach((text) => {
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
        console.error('printCustomerTable error:', e);
      }
    }

    // ====== BIND HANDLERS ======
    function bindCustomerPageHandlers() {
      const btnFilter = document.getElementById('applyFilter');
      if (btnFilter) btnFilter.onclick = applyCustomerFilters;

      const inputSearch = document.getElementById('search');
      if (inputSearch) {
        inputSearch.onkeydown = (e) => {
          if (e.key === 'Enter') applyCustomerFilters();
        };
      }

      const btnPrint = document.getElementById('printCustomerBtn');
      if (btnPrint) btnPrint.onclick = printCustomerTable;
    }

    // Ekspor global (opsional)
    window.applyCustomerFilters = applyCustomerFilters;
    window.printCustomerTable = printCustomerTable;

    // Bind awal & setelah wire:navigate (Livewire v3)
    document.addEventListener('DOMContentLoaded', bindCustomerPageHandlers);
    document.addEventListener('livewire:navigated', bindCustomerPageHandlers);
  </script>
@endpush
