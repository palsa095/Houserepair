@extends('layouts.landing')

@section('title', 'Form')

@section('content')
  <form method="POST" action="{{ route('customers.store') }}" class="mx-auto max-w-4xl space-y-4 p-6">
    @csrf
    <h1 class="mb-4 text-center text-3xl font-bold text-emerald-400">Fill your data</h1>

    <div>
      <x-input-label for="name" value="Nama" />
      <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name', $userName)" required autofocus />
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="phone" value="No. Telp" />
      <x-text-input id="phone" class="mt-1 block w-full" type="number" name="phone" :value="old('phone')" required />
      <x-input-error :messages="$errors->get('phone')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="address" value="Alamat" />
      <textarea id="address" name="address" @if(!empty($defaultAddressLine)) readonly @endif required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('address', $defaultAddressLine) }}</textarea>
      <x-input-error :messages="$errors->get('address')" class="mt-2" />
      @if (empty($defaultAddressLine))
        <p class="mt-2 text-sm text-red-600">Silakan atur default address di halaman Address sebelum membuat order.</p>
        <a href="{{ route('landing.address') }}" class="mt-2 inline-block text-sm text-emerald-600 underline">Buka halaman Address</a>
      @endif
    </div>

    <div>
      <x-input-label for="note" value="Keterangan" />
      <textarea id="note" name="note" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('note') }}</textarea>
      <x-input-error :messages="$errors->get('note')" class="mt-2" />
    </div>

    <x-input-label for="category" value="Kategori" />
    <div class="flex justify-start">
      <div class="grid grid-cols-2 gap-4">
        <img src="{{ asset('img/paket-' . request()->route('id') . '.png') }}" alt="Rumah Luar" class="mx-auto mb-6 h-64 w-64 rounded-xl object-cover">

        <div>
          @if (request()->route('id') == 1)
            <h5 class="my-2 rounded-xl border border-gray-500 p-2 text-xl">Paket Besar</h5>
            <p class="my-2 rounded-xl border border-gray-500 p-2 text-xl">Renovasi Keseluruhan Rumah</p>
            <input type="hidden" name="category" value="Paket Besar">
            <input type="hidden" name="project" value="Renovasi Keseluruhan Rumah">
          @elseif(request()->route('id') == 2)
            <h5 class="my-2 rounded-xl border border-gray-500 p-2 text-xl">Paket Sedang</h5>
            <p class="my-2 rounded-xl border border-gray-500 p-2 text-xl">Reservasi</p>
            <input type="hidden" name="category" value="Paket Sedang">
            <input type="hidden" name="project" value=" Reservasi">
          @elseif(request()->route('id') == 3)
            <h5 class="my-2 rounded-xl border border-gray-500 p-2 text-xl"">Paket Kecil</h5>
            <p class="my-2 rounded-xl border border-gray-500 p-2 text-xl">Reservasi</p>
            <input type="hidden" name="category" value="Paket Kecil">
            <input type="hidden" name="project" value=" Reservasi">
          @else
            <h5 class="my-2 rounded-xl border border-gray-500 p-2 text-xl">Paket Tidak Dikenali</h5>
            <p class="my-2 rounded-xl border border-gray-500 p-2 text-xl">Silakan pilih paket yang tersedia</p>
          @endif
        </div>
      </div>
    </div>

    <div class="mt-6 flex w-full">
      <button type="submit" class="w-full rounded-lg bg-black py-3 text-center text-white @if (empty($defaultAddressLine)) opacity-60 cursor-not-allowed @endif" @if (empty($defaultAddressLine)) disabled @endif>
        Submit
      </button>
    </div>
  </form>
@endsection
