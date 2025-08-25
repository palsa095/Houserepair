@extends('layouts.landing')

@section('title', 'Home')

@section('content')
  <div class="relative">
    <img src="{{ asset('img/hero-bg.png') }}" alt="Gereja" class="h-[691px] w-full object-cover" />
  </div>

  <!-- House Repair -->
  <section class="container mx-auto px-6 py-12">
    <div class="flex flex-col items-center rounded-lg bg-white p-6 shadow md:flex-row">
      <div class="flex-1">
        <h2 class="text-lg font-semibold text-green-600">House Repair</h2>
        <p class="mt-2 text-gray-600">Perbaikan rumah dengan cepat dan profesional.</p>
      </div>
      <div class="mt-4 md:mt-0">
        <a href="#" class="inline-block rounded-lg bg-black px-5 py-2 text-white transition hover:bg-gray-800">
          Contact Our Service
        </a>
      </div>
    </div>

    <!-- Artikel kecil -->
    <div class="mt-10 grid gap-8 md:grid-cols-2">
      <div class="flex gap-4">
        <img src="https://via.placeholder.com/100" class="h-24 w-24 rounded-lg object-cover" />
        <div>
          <h3 class="text-lg font-semibold">What is Lorem Ipsum?</h3>
          <p class="text-sm text-gray-600">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </div>
      </div>
      <div class="flex gap-4">
        <img src="https://via.placeholder.com/100" class="h-24 w-24 rounded-lg object-cover" />
        <div>
          <h3 class="text-lg font-semibold">Why do we use it?</h3>
          <p class="text-sm text-gray-600">It is a long established fact that a reader will be distracted by the readable content.</p>
        </div>
      </div>
      <div class="flex gap-4">
        <img src="https://via.placeholder.com/100" class="h-24 w-24 rounded-lg object-cover" />
        <div>
          <h3 class="text-lg font-semibold">Where can I get some?</h3>
          <p class="text-sm text-gray-600">There are many variations of passages of Lorem Ipsum available.</p>
        </div>
      </div>
      <div class="flex gap-4">
        <img src="https://via.placeholder.com/100" class="h-24 w-24 rounded-lg object-cover" />
        <div>
          <h3 class="text-lg font-semibold">Another Example</h3>
          <p class="text-sm text-gray-600">Some quick example text to build on the card title and make up the bulk of the content.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Order -->
  <section class="container mx-auto px-6 py-12">
    <div class="flex flex-col items-center rounded-lg bg-white p-6 shadow md:flex-row">
      <div class="flex-1">
        <h2 class="text-lg font-semibold text-green-600">Order</h2>
        <p class="mt-2 text-gray-600">Pilih paket sesuai kebutuhan Anda.</p>
      </div>
    </div>

    <div class="mt-10 grid gap-8 md:grid-cols-2">
      <div>
        <img src="https://via.placeholder.com/300x200" class="rounded-lg shadow" />
      </div>
      <div>
        <h3 class="text-xl font-semibold">Paket Besar</h3>
        <p class="mt-2 text-gray-600">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p>
      </div>
    </div>
  </section>

  <!-- Invoice -->
  <section class="container mx-auto px-6 py-12">
    <div class="flex flex-col items-center rounded-lg bg-white p-6 shadow md:flex-row">
      <div class="flex-1">
        <h2 class="text-lg font-semibold text-green-600">Invoice</h2>
        <p class="mt-2 text-gray-600">Lihat tagihan Anda dengan mudah.</p>
      </div>
      <div class="mt-4 md:mt-0">
        <a href="#" class="inline-block rounded-lg bg-black px-5 py-2 text-white transition hover:bg-gray-800">
          Contact Our Service
        </a>
      </div>
    </div>
  </section>
@endsection
