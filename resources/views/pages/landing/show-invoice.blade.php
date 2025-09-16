@extends('layouts.landing')

@section('title', 'Show Invoice')

@push('styles')
  <style>
    /* ukuran & margin cetak A4 */
    @media print {
      @page {
        size: A4;
        margin: 18mm;
      }

      .no-print {
        display: none !important;
      }

      body {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }
    }

    /* pola titik lembut seperti pada gambar */
    .dot-bg {
      background-image: radial-gradient(rgba(0, 0, 0, .05) 1px, transparent 1px);
      background-size: 10px 10px;
    }
  </style>
@endpush

@section('content')
  {{-- Toolbar (non-print) --}}
  <div class="no-print z-10 border-b bg-white/80 backdrop-blur">
    <div class="mx-auto flex max-w-4xl items-center justify-between px-4 py-3">
      <h1 class="text-2xl font-extrabold tracking-tight">This Your Invoice:</h1>
      <button onclick="window.print()" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-white hover:bg-slate-800">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
          <path d="M6 2h12v6H6z" />
          <path d="M6 14h12v8H6z" />
          <path d="M4 10h16a2 2 0 0 1 2 2v2h-3v-1a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1v1H2v-2a2 2 0 0 1 2-2z" />
        </svg>
        Print
      </button>
    </div>
  </div>

  <div class="bg-gray-50 text-slate-700">
    <div class="mx-auto max-w-4xl bg-white shadow-sm print:bg-white print:shadow-none">
      {{-- Header --}}
      <div class="dot-bg relative p-8 md:p-10">
        <div class="flex items-start justify-between">
          {{-- Logo & Brand --}}
          <div class="flex items-center gap-3">
            <img src="{{ asset('/logo.png') }}" alt="Logo" class="h-12 w-auto rounded p-1" />
          </div>

          {{-- Invoice Title & No --}}
          <div class="text-right">
            <p class="text-3xl font-semibold leading-tight text-slate-300">Invoice</p>
            <p class="text-sm text-slate-600">#{{ $invoice->number }}</p>
          </div>
        </div>

        {{-- Meta grid --}}
        <div class="mt-10 grid grid-cols-2 justify-center gap-6 md:grid-cols-4">
          <div>
            <p class="text-xs uppercase tracking-wide text-slate-400">Billed To</p>
            <div class="mt-2 space-y-0.5">
              <p class="font-semibold">{{ $invoice->customer_name }}</p>
              @if (!empty($invoice->customer_address))
                <p class="text-sm">{{ $invoice->customer_address }}</p>
              @endif
              @if (!empty($invoice->customer_phone))
                <p class="text-sm">{{ $invoice->customer_phone }}</p>
              @endif
            </div>
          </div>

          <div>
            <p class="text-xs uppercase tracking-wide text-slate-400">Orders</p>
            <div class="mt-2 space-y-0.5">
              @if (!empty($invoice->package))
                <p class="font-semibold">{{ $invoice->package }}</p>
              @endif
              @if (!empty($invoice->project))
                <p class="text-sm">{{ $invoice->project }}</p>
              @endif
            </div>
          </div>

          <div class="md:pl-6">
            <p class="text-xs uppercase tracking-wide text-slate-400">Invoice Date</p>
            <p class="mt-2 font-semibold">
              {{ \Illuminate\Support\Carbon::parse($invoice->date)->translatedFormat('d.m.Y') }}
            </p>
          </div>

          <div>
            <p class="text-xs uppercase tracking-wide text-slate-400">Amount Due</p>
            <div class="mt-2 inline-flex items-center rounded-md bg-lime-200 px-4 py-2">
              <span class="text-sm font-semibold text-slate-700">
                {{ $invoice->currency }} {{ number_format((float) ($invoice->total ?? 0), 0, ',', '.') }}
              </span>
            </div>
          </div>
        </div>
      </div>

      {{-- Items table --}}
      <div class="px-6 pb-10 md:px-10">
        <div class="mt-6 overflow-hidden rounded-xl border border-slate-200">
          <table class="w-full text-sm">
            <thead class="bg-slate-50">
              <tr class="text-left text-slate-500">
                <th class="w-14 px-4 py-3">#</th>
                <th class="px-4 py-3">Title / Description</th>
                <th class="w-40 px-4 py-3 text-right">Subtotal</th>
              </tr>
            </thead>

            @php
              // Normalisasi: support Eloquent Collection atau array biasa
              $items = collect($invoice->items ?? [])->map(function ($it) {
                  return [
                      'title' => data_get($it, 'title'),
                      'description' => data_get($it, 'description'),
                      'subtotal' => (float) data_get($it, 'subtotal', 0),
                  ];
              });
              $computedTotal = $items->sum('subtotal');
              $grandTotal = $invoice->total ?? $computedTotal;
            @endphp

            <tbody class="divide-y divide-slate-100">
              @forelse ($items as $i => $item)
                <tr>
                  <td class="px-4 py-4 align-top text-slate-500">{{ $i + 1 }}</td>
                  <td class="px-4 py-4">
                    <p class="font-medium">{{ $item['title'] }}</p>
                    @if (!empty($item['description']))
                      <p class="mt-1 text-xs text-slate-500">{{ $item['description'] }}</p>
                    @endif
                  </td>
                  <td class="px-4 py-4 text-right">
                    {{ $invoice->currency }}
                    {{ number_format($item['subtotal'], 0, ',', '.') }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" class="px-4 py-6 text-center text-slate-500">
                    Belum ada item pada invoice ini.
                  </td>
                </tr>
              @endforelse
            </tbody>

            <tfoot>
              <tr>
                <td colspan="2" class="px-4 py-4 text-right font-semibold">Total</td>
                <td class="px-4 py-4 text-right font-semibold">
                  {{ $invoice->currency }}
                  {{ number_format((float) $grandTotal, 0, ',', '.') }}
                </td>
              </tr>
            </tfoot>
          </table>
        </div>

        <p class="my-12 text-center text-sm font-semibold text-slate-400">
          Thank you for the business!
        </p>
      </div>
    </div>
  </div>
@endsection
