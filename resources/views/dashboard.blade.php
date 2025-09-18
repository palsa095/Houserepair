@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
  <main class="px-6 pb-10">
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

      {{-- Card: Total Hasil Survey --}}
      @if (Route::has('surveys.index'))
        <a href="{{ route('surveys.index') }}" class="block group">
      @else
        <div>
      @endif
          <div class="relative p-5 overflow-hidden transition bg-white shadow rounded-2xl hover:shadow-lg dark:bg-gray-800">
            <div class="absolute inset-0 pointer-events-none bg-gradient-to-r from-indigo-500 to-indigo-600 opacity-10"></div>
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Hasil Survey</p>
                <h3 class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                  {{ number_format($totalHasilSurvey ?? 0, 0, ',', '.') }}
                </h3>
              </div>
              <div class="p-3 rounded-xl bg-indigo-50 dark:bg-indigo-900/30">
                <i class="text-xl text-indigo-600 fa-solid fa-clipboard-check dark:text-indigo-400"></i>
              </div>
            </div>
            @if (Route::has('surveys.index'))
              <p class="mt-3 text-xs text-gray-400 group-hover:text-gray-500">Klik untuk lihat detail</p>
            @endif
          </div>
      @if (Route::has('surveys.index'))</a>@else</div>@endif

      {{-- Card: Total Barang --}}
      @if (Route::has('materials.index'))
        <a href="{{ route('materials.index') }}" class="block group">
      @else
        <div>
      @endif
          <div class="relative p-5 overflow-hidden transition bg-white shadow rounded-2xl hover:shadow-lg dark:bg-gray-800">
            <div class="absolute inset-0 pointer-events-none bg-gradient-to-r from-emerald-500 to-emerald-600 opacity-10"></div>
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Barang</p>
                <h3 class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                  {{ number_format($totalBarang ?? 0, 0, ',', '.') }}
                </h3>
              </div>
              <div class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/30">
                <i class="text-xl fa-solid fa-boxes-stacked text-emerald-600 dark:text-emerald-400"></i>
              </div>
            </div>
            @if (Route::has('materials.index'))
              <p class="mt-3 text-xs text-gray-400 group-hover:text-gray-500">Klik untuk lihat detail</p>
            @endif
          </div>
      @if (Route::has('materials.index'))</a>@else</div>@endif

      {{-- Card: Jumlah Transaksi --}}
      @if (Route::has('invoices.index'))
        <a href="{{ route('invoices.index') }}" class="block group">
      @else
        <div>
      @endif
          <div class="relative p-5 overflow-hidden transition bg-white shadow rounded-2xl hover:shadow-lg dark:bg-gray-800">
            <div class="absolute inset-0 pointer-events-none bg-gradient-to-r from-amber-500 to-amber-600 opacity-10"></div>
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Transaksi</p>
                <h3 class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                  {{ number_format($jumlahTransaksi ?? 0, 0, ',', '.') }}
                </h3>
              </div>
              <div class="p-3 rounded-xl bg-amber-50 dark:bg-amber-900/30">
                <i class="text-xl fa-solid fa-receipt text-amber-600 dark:text-amber-400"></i>
              </div>
            </div>
            @if (Route::has('invoices.index'))
              <p class="mt-3 text-xs text-gray-400 group-hover:text-gray-500">Klik untuk lihat detail</p>
            @endif
          </div>
      @if (Route::has('invoices.index'))</a>@else</div>@endif

    </div>
  </main>
@endsection
