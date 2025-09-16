<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', config('app.name', 'House Repair'))</title>

  {{-- Font Awesome --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  {{-- Vite (Tailwind + JS) --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
  <nav class="bg-gray-800 py-1 text-white shadow">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">

        {{-- Logo --}}
        <div class="flex items-center">
          <a href="{{ route('landing.home') }}" class="flex items-center space-x-2">
            <img src="{{ asset('/logo.png') }}" class="mb-4 mt-2 p-4" />
          </a>
        </div>

        {{-- Menu Tengah --}}
        <div class="space-x-6 md:flex">
          <a href="{{ route('landing.home') }}" class="{{ request()->routeIs('landing.home') ? 'text-emerald-400 border-b-2 border-emerald-400' : 'hover:text-emerald-400' }} px-2 py-3 text-sm">
            Home
          </a>
          <a href="{{ route('landing.about') }}" class="{{ request()->routeIs('landing.about') ? 'text-emerald-400 border-b-2 border-emerald-400' : 'hover:text-emerald-400' }} px-2 py-3 text-sm">
            About
          </a>
          <a href="{{ route('landing.order') }}" class="{{ request()->routeIs('landing.order') ? 'text-emerald-400 border-b-2 border-emerald-400' : 'hover:text-emerald-400' }} px-2 py-3 text-sm">
            Order
          </a>
          <a href="{{ route('landing.invoice') }}" class="{{ request()->routeIs('landing.invoice') ? 'text-emerald-400 border-b-2 border-emerald-400' : 'hover:text-emerald-400' }} px-2 py-3 text-sm">
            Invoice
          </a>
        </div>

        {{-- Right Side --}}
        <div class="flex items-center space-x-4">
          @auth
            {{-- Notifikasi --}}
            <button class="relative text-gray-300 hover:text-white">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
            </button>

            {{-- User --}}
            <div class="flex items-center space-x-2">
              <img class="h-8 w-8 rounded-full border border-gray-600" src="https://i.pravatar.cc/40" alt="user">
              <span class="text-sm">{{ Auth::user()->name }}</span>
            </div>
          @else
            {{-- Tombol Login & Register --}}
            <div class="flex space-x-3">
              <a href="{{ route('login') }}" class="rounded border border-emerald-400 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-400">
                Login
              </a>
              <a href="{{ route('register') }}" class="rounded bg-emerald-400 px-4 py-2 text-sm font-medium text-black hover:bg-emerald-400">
                Register
              </a>
            </div>
          @endauth
        </div>
      </div>
    </div>
  </nav>

  {{-- Page content --}}
  <main>
    {{-- Toast --}}
    <x-toast />

    @yield('content')
  </main>

  <footer class="bg-gray-800 py-12 text-gray-200">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="grid grid-cols-3 gap-8 py-4">

        {{-- Logo & Info --}}
        <div class="col-span-2">
          <div class="mb-4 flex items-center space-x-2">
            <img src="{{ asset('/logo.png') }}" />
          </div>
          <a href="#" class="mt-2 inline-block rounded bg-emerald-400 px-4 py-2 text-sm font-medium text-black hover:bg-emerald-400">
            More Info
          </a>
        </div>

        {{-- Kontak --}}
        <div class="col-span-1 space-y-4 text-sm">
          <div class="flex items-start space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 12.414M21 21l-4.243-4.243m0 0A9 9 0 1116.243 4.757a9 9 0 010 12.728z" />
            </svg>
            <p>Jl. Kaliurang Km 13, Mbesi, Sukoharjo, Ngaglik, Sleman Yogyakarta</p>
          </div>
          <div class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 0a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <p>houserepair@gmail.com</p>
          </div>
          <div class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m0 4h12M9 7v2m0 4h12m-6-2v2" />
            </svg>
            <p>+62 821 5634 9859</p>
          </div>
        </div>
      </div>

      {{-- Bottom --}}
      <div class="mt-10 flex flex-col items-center justify-between border-t border-gray-700 pt-6 text-sm md:flex-row">
        <p>Since ©2024. <a href="#" class="hover:underline">Terms & Conditions</a></p>

        <div class="mt-4 flex space-x-6 md:mt-0">
          <a href="#" class="mx-2 hover:text-emerald-400"><i class="fab fa-whatsapp"></i></a>
          <a href="#" class="mx-2 hover:text-emerald-400"><i class="fab fa-instagram"></i></a>
          <a href="#" class="mx-2 hover:text-emerald-400"><i class="fab fa-twitter"></i></a>
          <a href="#" class="mx-2 hover:text-emerald-400"><i class="fab fa-telegram"></i></a>
        </div>
      </div>
    </div>
  </footer>

  {{-- Alpine.js --}}
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <style>
    [x-cloak] {
      display: none !important;
    }
  </style>
</body>

</html>
