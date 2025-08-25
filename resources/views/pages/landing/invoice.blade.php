@extends('layouts.landing')

@section('title', 'Invoice')

@section('content')
  <div class="min-h-screen bg-white p-4">
    <!-- Search & Menu -->
    <div class="mb-6 flex items-center justify-between">
      <div class="flex w-full max-w-md items-center rounded-full border px-3 py-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
        </svg>
        <input type="text" placeholder="Search..." class="ml-2 w-full border-0 text-sm outline-none focus:ring-0" />
      </div>
      <button class="ml-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>

    <!-- Card 1 -->
    <div class="mb-4 flex items-center justify-between rounded-lg border border-green-600 p-4">
      <div>
        <span class="text-lg font-bold text-green-600">1</span>
        <div class="mt-2 text-lg font-semibold">Paket Besar</div>
        <div class="text-gray-700">Renovasi Taman</div>
        <div class="mt-2 text-sm text-green-500">● Sedang diproses...</div>
      </div>
      <div class="text-center">
        <div class="mb-2 h-28 w-20 bg-gray-300"></div>
        <a href="#" class="text-sm text-gray-600">See Invoice&gt;&gt;&gt;</a>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="flex items-center justify-between rounded-lg border border-green-600 bg-black p-4">
      <div>
        <span class="text-lg font-bold text-green-600">2</span>
        <div class="mt-2 text-lg font-semibold text-white">Paket Kecil</div>
        <div class="text-white">Cat Ulang Tembok Kamar</div>
        <div class="mt-2 text-sm text-green-500">● Diterima</div>
      </div>
      <div class="text-center">
        <div class="mb-2 h-28 w-20 bg-gray-300"></div>
        <a href="#" class="text-sm text-gray-300">See Invoice&gt;&gt;&gt;</a>
      </div>
    </div>
  </div>
@endsection
