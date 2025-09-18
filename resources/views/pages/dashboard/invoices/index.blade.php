@extends('layouts.app')

@section('title', 'Invoice')

@section('content')
  <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
    {{-- Search and Filters --}}
    <div class="flex flex-col gap-4 mb-4 md:flex-row md:items-center md:justify-between">
      <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
        {{-- Search Input --}}
        <div class="relative">
          <input type="text" id="search" placeholder="Search nomor/nama/proyek/paket..." class="block w-full p-2 pl-3 text-sm bg-white border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white" value="{{ request('search') }}">
        </div>

        {{-- Date Range Filter --}}
        <div class="flex items-center gap-2">
          <input type="date" id="startDate" class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-800 dark:text-white" value="{{ request('start_date') }}">
          <span class="text-sm text-gray-500">to</span>
          <input type="date" id="endDate" class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-800 dark:text-white" value="{{ request('end_date') }}">

          {{-- Apply Filter --}}
          <button type="button" id="applyFilter" class="flex items-center p-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="mr-2 fa-solid fa-filter"></i>
          </button>

          {{-- Reset --}}
          <a href="{{ route('invoices.index') }}" class="flex items-center p-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="mr-2 fa-solid fa-rotate-left"></i>
          </a>
        </div>
      </div>

      {{-- Action Buttons --}}
      <div class="flex gap-2">
        <button type="button" id="printInvoiceBtn" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
          <i class="mr-2 fa-solid fa-print"></i> Print
        </button>

        <x-primary-button x-on:click="$dispatch('open-modal', 'createInvoice')">
          <i class="mr-2 fa-solid fa-plus"></i>Tambah
        </x-primary-button>
      </div>
    </div>

    {{-- Table --}}
    @if ($invoices->isEmpty())
      <div class="p-8 text-center border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 dark:border-gray-600 dark:bg-gray-800">
        <i class="text-5xl text-gray-400 fa-solid fa-database dark:text-gray-500"></i>
        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Data tidak tersedia</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
          @if (request()->hasAny(['search', 'start_date', 'end_date']))
            Tidak ada data yang cocok dengan filter Anda.
          @else
            Belum ada data invoice yang tersimpan.
          @endif
        </p>
        <div class="mt-6">
          @if (request()->hasAny(['search', 'start_date', 'end_date']))
            <a href="{{ route('invoices.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
              <i class="mr-2 fa-solid fa-filter-circle-xmark"></i> Reset Filter
            </a>
          @else
            <x-primary-button x-on:click="$dispatch('open-modal', 'createInvoice')">
              <i class="mr-2 fa-solid fa-plus"></i>Tambah Invoice Pertama
            </x-primary-button>
          @endif
        </div>
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse" id="invoiceTable">
          <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
              <th class="p-2">#</th>
              <th class="p-2">Nama</th>
              <th class="p-2">Keterangan</th>
              <th class="p-2">Keperluan Barang</th>
              <th class="p-2">Total Harga</th>
              <th class="p-2 text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($invoices as $i => $invoice)
              @php
                $titles = $invoice->items->pluck('title')->filter()->values();
                $joined = $titles->take(3)->implode(', ');
                if ($titles->count() > 3) {
                    $joined .= ' +' . ($titles->count() - 3) . ' lainnya';
                }
              @endphp
              <tr class="border-b dark:border-gray-600">
                <td class="p-2">{{ $invoices->firstItem() + $i }}</td>
                <td class="p-2">
                  <div class="font-medium">{{ $invoice->customer_name }}</div>
                  <div class="text-xs text-gray-500">#{{ $invoice->number }} • {{ \Illuminate\Support\Carbon::parse($invoice->date)->format('d/m/Y') }}</div>
                </td>
                <td class="p-2">
                  {{ trim(($invoice->project ?? '') . ($invoice->package ? " ({$invoice->package})" : '')) ?: '-' }}
                </td>
                <td class="p-2">{{ $joined ?: '-' }}</td>
                <td class="p-2">{{ $invoice->currency }} {{ number_format($invoice->total, 0, ',', '.') }}</td>
                <td class="p-3 align-middle">
                  <div class="flex justify-center gap-2">
                    <a class="text-indigo-600 hover:text-indigo-800" href="{{ route('landing.showinvoice', $invoice) }}" title="Lihat">
                      <i class="fa-solid fa-eye"></i>
                    </a>
                    <button type="button" class="text-yellow-500 hover:text-yellow-700" @click="$dispatch('open-modal', 'editInvoice{{ $invoice->id }}')" title="Edit">
                      <i class="fa-solid fa-pen"></i>
                    </button>
                    <button type="button" class="text-red-500 hover:text-red-700" @click="$dispatch('open-modal', 'deleteInvoice{{ $invoice->id }}')" title="Hapus">
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
      @if ($invoices->hasPages())
        <div class="mt-4">
          {{ $invoices->withQueryString()->links() }}
        </div>
      @endif
    @endif
  </div>

  {{-- Modals --}}
  @includeIf('pages.dashboard.invoices.create')
  @foreach ($invoices as $invoice)
    @includeIf('pages.dashboard.invoices.edit', ['invoice' => $invoice])
    @includeIf('pages.dashboard.invoices.delete', ['invoice' => $invoice])
  @endforeach
@endsection

@push('scripts')
<script>
  // ====== FILTER ======
  function applyInvoiceFilters() {
    try {
      const searchInput = document.getElementById('search');
      const startDate   = document.getElementById('startDate');
      const endDate     = document.getElementById('endDate');

      const params = new URLSearchParams();
      if (searchInput && searchInput.value) params.set('search', searchInput.value);
      if (startDate && startDate.value)     params.set('start_date', startDate.value);
      if (endDate && endDate.value)         params.set('end_date',   endDate.value);

      window.location.href = `${window.location.pathname}?${params.toString()}`;
    } catch (e) { console.error('applyInvoiceFilters error:', e); }
  }

  function printInvoiceTable() {
    try {
      const printWindow = window.open('', '', 'height=600,width=800');
      printWindow.document.write('<html><head><title>Data Penyediaan Barang</title>');
      printWindow.document.write('<style>');
      printWindow.document.write(`
        body { font-family: Arial, sans-serif; margin: 1cm; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
        .date { text-align: right; margin-bottom: 10px; font-size: 0.9em; }
      `);
      printWindow.document.write('</style></head><body>');

      printWindow.document.write('<div class="header"><h2>Data Penyediaan Barang</h2></div>');
      printWindow.document.write(`<div class="date">Printed on: ${
        new Date().toLocaleDateString('id-ID', { weekday:'long', year:'numeric', month:'long', day:'numeric' })
      }</div>`);

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

      @foreach ($invoices as $idx => $invoice)
        @php
          $no      = $invoices->firstItem() + $idx;
          $cust    = $invoice->customer_name;
          $num     = $invoice->number;
          $dateStr = \Illuminate\Support\Carbon::parse($invoice->date)->format('d/m/Y');
          $nama    = "{$cust} (#{$num} • {$dateStr})";

          $ket     = trim(($invoice->project ?? '') . ($invoice->package ? ' (' . $invoice->package . ')' : '')) ?: '-';

          $items   = $invoice->items->pluck('title')->filter()->values()->all();
          $joined  = implode(', ', array_slice($items, 0, 3));
          if (!$joined) $joined = '-';
          if (count($items) > 3) $joined .= ' +' . (count($items) - 3) . ' lainnya';

          $total   = $invoice->currency . ' ' . number_format($invoice->total, 0, ',', '.');

          // satu paket data untuk baris ini:
          $cells   = [$no, $nama, $ket, $joined, $total];
        @endphp
        (function () {
          const row = document.createElement('tr');
          const cells = @json($cells);
          cells.forEach(function (text) {
            const td = document.createElement('td');
            td.textContent = String(text);
            row.appendChild(td);
          });
          tbody.appendChild(row);
        })();
      @endforeach

      table.appendChild(tbody);
      printWindow.document.body.appendChild(table);
      printWindow.document.close();
      printWindow.focus();
      setTimeout(() => { printWindow.print(); printWindow.close(); }, 300);
    } catch (e) { console.error('printInvoiceTable error:', e); }
  }

  // ====== BIND HANDLERS ======
  function bindInvoicePageHandlers() {
    const btnFilter = document.getElementById('applyFilter');
    if (btnFilter) btnFilter.onclick = applyInvoiceFilters;

    const inputSearch = document.getElementById('search');
    if (inputSearch) inputSearch.onkeydown = (e)=>{ if (e.key === 'Enter') applyInvoiceFilters(); };

    const btnPrint = document.getElementById('printInvoiceBtn');
    if (btnPrint) btnPrint.onclick = printInvoiceTable;
  }

  // Optional export
  window.applyInvoiceFilters = applyInvoiceFilters;
  window.printInvoiceTable   = printInvoiceTable;

  // Bind awal & setelah wire:navigate (Livewire v3)
  document.addEventListener('DOMContentLoaded', bindInvoicePageHandlers);
  document.addEventListener('livewire:navigated', bindInvoicePageHandlers);
</script>
@endpush

