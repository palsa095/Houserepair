@extends('layouts.landing')

@section('title', 'Order')

@section('content')
  <div class="relative">
    <img src="{{ asset('img/hero-bg.png') }}" alt="Gereja" class="h-[691px] w-full object-cover" />
  </div>

  <section class="bg-white py-16">
    <div class="mx-auto max-w-7xl p-6">
      <!-- Section Title -->
      <div class="mb-6 text-left">
        <h2 class="text-2xl font-bold text-emerald-300 md:text-3xl">Paket Besar</h2>
        <p class="mt-1 text-sm text-gray-500">
          Semua penjelasan tentang pelayanan kami, dapat anda baca disini.
        </p>
      </div>

      <!-- Cards -->
      <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <!-- Card 1 -->
        <div style="background-color: #003000" class="flex flex-col justify-between rounded-xl p-8 text-center shadow-lg">
          <h3 class="mb-4 font-semibold text-white">
            Renovasi Keseluruhan <br> Rumah Luar
          </h3>
          <img src="{{ asset('img/paket-1.png') }}" alt="Rumah Luar" class="mx-auto mb-6 h-72 w-full rounded-xl object-cover">
          <a href="{{ route('landing.order.form', ['id' => 1]) }}" class="mx-12 my-8 rounded-full bg-white px-6 py-2 font-medium transition hover:bg-gray-100">
            Order
          </a>
        </div>

        <!-- Card 2 -->
        <div style="background-color: #003000" class="flex flex-col justify-between rounded-xl p-8 text-center shadow-lg">
          <h3 class="mb-4 font-semibold text-white">
            Renovasi Keseluruhan <br> Rumah Dalam
          </h3>
          <img src="{{ asset('img/paket-2.png') }}" alt="Rumah Dalam" class="mx-auto mb-6 h-72 w-full rounded-xl object-cover">
          <a href="{{ route('landing.order.form', ['id' => 1]) }}" class="mx-12 my-8 rounded-full bg-white px-6 py-2 font-medium transition hover:bg-gray-100">
            Order
          </a>
        </div>

        <!-- Card 3 -->
        <div style="background-color: #003000" class="flex flex-col justify-between rounded-xl p-8 text-center shadow-lg">
          <h3 class="mb-4 font-semibold text-white">
            Renovasi Keseluruhan <br> Taman
          </h3>
          <img src="{{ asset('img/paket-3.png') }}" alt="Taman" class="mx-auto mb-6 h-72 w-full rounded-xl object-cover">
          <a href="{{ route('landing.order.form', ['id' => 1]) }}" class="mx-12 my-8 rounded-full bg-white px-6 py-2 font-medium transition hover:bg-gray-100">
            Order
          </a>
        </div>

      </div>
    </div>
    <div class="mx-auto max-w-7xl p-6">
      <!-- Section Title -->
      <div class="mb-6 text-left">
        <h2 class="text-2xl font-bold text-emerald-300 md:text-3xl">Paket Sedang</h2>
        <p class="mt-1 text-sm text-gray-500">
          Semua penjelasan tentang pelayanan kami, dapat anda baca disini.
        </p>
      </div>

      <!-- Cards -->
      <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <!-- Card 1 -->
        <div style="background-color: #003000" class="flex flex-col justify-between rounded-xl p-8 text-center shadow-lg">
          <h3 class="mb-4 font-semibold text-white">
            Renovasi Keseluruhan <br> Rumah Luar
          </h3>
          <img src="{{ asset('img/paket-1.png') }}" alt="Rumah Luar" class="mx-auto mb-6 h-72 w-full rounded-xl object-cover">
          <a href="{{ route('landing.order.form', ['id' => 2]) }}" class="mx-12 my-8 rounded-full bg-white px-6 py-2 font-medium transition hover:bg-gray-100">
            Order
          </a>
        </div>

        <!-- Card 2 -->
        <div style="background-color: #003000" class="flex flex-col justify-between rounded-xl p-8 text-center shadow-lg">
          <h3 class="mb-4 font-semibold text-white">
            Renovasi Keseluruhan <br> Rumah Dalam
          </h3>
          <img src="{{ asset('img/paket-2.png') }}" alt="Rumah Dalam" class="mx-auto mb-6 h-72 w-full rounded-xl object-cover">
          <a href="{{ route('landing.order.form', ['id' => 2]) }}" class="mx-12 my-8 rounded-full bg-white px-6 py-2 font-medium transition hover:bg-gray-100">
            Order
          </a>
        </div>

        <!-- Card 3 -->
        <div style="background-color: #003000" class="flex flex-col justify-between rounded-xl p-8 text-center shadow-lg">
          <h3 class="mb-4 font-semibold text-white">
            Renovasi Keseluruhan <br> Taman
          </h3>
          <img src="{{ asset('img/paket-3.png') }}" alt="Taman" class="mx-auto mb-6 h-72 w-full rounded-xl object-cover">
          <a href="{{ route('landing.order.form', ['id' => 2]) }}" class="mx-12 my-8 rounded-full bg-white px-6 py-2 font-medium transition hover:bg-gray-100">
            Order
          </a>
        </div>

      </div>
    </div>
    <div class="mx-auto max-w-7xl p-6">
      <!-- Section Title -->
      <div class="mb-6 text-left">
        <h2 class="text-2xl font-bold text-emerald-300 md:text-3xl">Paket Kecil</h2>
        <p class="mt-1 text-sm text-gray-500">
          Semua penjelasan tentang pelayanan kami, dapat anda baca disini.
        </p>
      </div>

      <!-- Cards -->
      <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <!-- Card 1 -->
        <div style="background-color: #003000" class="flex flex-col justify-between rounded-xl p-8 text-center shadow-lg">
          <h3 class="mb-4 font-semibold text-white">
            Renovasi <br> Rumah Luar
          </h3>
          <img src="{{ asset('img/paket-1.png') }}" alt="Rumah Luar" class="mx-auto mb-6 h-72 w-full rounded-xl object-cover">
          <a href="{{ route('landing.order.form', ['id' => 3]) }}" class="mx-12 my-8 rounded-full bg-white px-6 py-2 font-medium transition hover:bg-gray-100">
            Order
          </a>
        </div>

        <!-- Card 2 -->
        <div style="background-color: #003000" class="flex flex-col justify-between rounded-xl p-8 text-center shadow-lg">
          <h3 class="mb-4 font-semibold text-white">
            Renovasi <br> Rumah Dalam
          </h3>
          <img src="{{ asset('img/paket-2.png') }}" alt="Rumah Dalam" class="mx-auto mb-6 h-72 w-full rounded-xl object-cover">
          <a href="{{ route('landing.order.form', ['id' => 3]) }}" class="mx-12 my-8 rounded-full bg-white px-6 py-2 font-medium transition hover:bg-gray-100">
            Order
          </a>
        </div>

        <!-- Card 3 -->
        <div style="background-color: #003000" class="flex flex-col justify-between rounded-xl p-8 text-center shadow-lg">
          <h3 class="mb-4 font-semibold text-white">
            Renovasi <br> Taman
          </h3>
          <img src="{{ asset('img/paket-3.png') }}" alt="Taman" class="mx-auto mb-6 h-72 w-full rounded-xl object-cover">
          <a href="{{ route('landing.order.form', ['id' => 3]) }}" class="mx-12 my-8 rounded-full bg-white px-6 py-2 font-medium transition hover:bg-gray-100">
            Order
          </a>
        </div>

      </div>
    </div>
  </section>

@endsection
