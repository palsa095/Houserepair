@extends('layouts.landing')

@section('title', 'Invoice')

@section('content')
  <div class="mx-auto min-h-screen max-w-6xl bg-white p-4">

    {{-- Search --}}
    <form method="GET" action="{{ url()->current() }}" class="mb-6 flex items-center justify-between">
      <div class="flex w-full max-w-md items-center rounded-full border px-3 py-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
        </svg>
        <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" class="ml-2 w-full border-0 text-sm outline-none focus:ring-0" />
      </div>
      <button type="submit" class="ml-3 rounded-lg border px-3 py-2 text-sm">Cari</button>
    </form>

    @forelse ($invoices as $invoice)
      @php
        // ganjil = putih, genap = hitam
        $isDark = $loop->even;
        $cardClass = $isDark ? 'flex items-center justify-between rounded-lg border border-green-600 bg-black p-4' : 'flex items-center justify-between rounded-lg border border-green-600 bg-white p-4';
        $titleClass = $isDark ? 'mt-2 text-lg font-semibold text-white' : 'mt-2 text-lg font-semibold';
        $descClass = $isDark ? 'text-white' : 'text-gray-700';
        $linkClass = $isDark ? 'text-sm text-gray-300' : 'text-sm text-gray-600';
      @endphp

      <div class="{{ $cardClass }} mb-4">
        <div>
          <span class="text-lg font-bold text-green-600">{{ $loop->iteration }}</span>
          <div class="{{ $titleClass }}">{{ $invoice->package ?? '—' }}</div>
          <div class="{{ $descClass }}">{{ $invoice->project ?? '—' }}</div>
          <div class="mt-2 text-sm text-green-500">
            • {{ \Illuminate\Support\Carbon::parse($invoice->date)->translatedFormat('d M Y') }}
          </div>
        </div>

        <div class="text-center">
          <div class="mb-2 h-28 w-20 rounded bg-gray-300"></div>

          {{-- pastikan route menerima model/ID: route('landing.showinvoice', $invoice) --}}
          <a href="{{ route('landing.showinvoice', $invoice) }}" class="{{ $linkClass }}">
            See Invoice &gt;&gt;&gt;
          </a>
        </div>
      </div>
    @empty
      <div class="rounded-lg border-2 border-dashed p-8 text-center text-gray-500">
        Tidak ada invoice.
      </div>
    @endforelse

    {{-- Pagination (jika pakai paginate di controller) --}}
    @if (method_exists($invoices, 'links'))
      <div class="mt-6">
        {{ $invoices->withQueryString()->links() }}
      </div>
    @endif
  </div>
@endsection
