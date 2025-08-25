<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
    darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
    sidebarOpen: false
}" x-init="$watch('darkMode', value => {
    localStorage.setItem('theme', value ? 'dark' : 'light');
    document.documentElement.classList.toggle('dark', value);
});
if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
} else {
    document.documentElement.classList.remove('dark');
}" :class="{ 'dark': darkMode }">

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

<body class="bg-gray-50 text-gray-900 antialiased dark:bg-gray-900 dark:text-gray-100">

  {{-- Wrapper --}}
  <div class="flex min-h-screen">

    {{-- Sidebar (desktop) --}}
    <aside class="hidden bg-gray-800 text-gray-100 lg:flex lg:w-64 lg:shrink-0 lg:flex-col">
      <div class="flex h-20 items-center gap-3 border-b border-gray-700 px-6">
        <i class="fa-solid fa-house-chimney text-2xl text-emerald-400"></i>
        <div>
          <div class="text-lg font-bold leading-tight text-white">House Repair</div>
          <div class="text-xs text-gray-400">Admin Panel</div>
        </div>
      </div>

      <nav class="flex-1 space-y-1 px-3 py-4 text-sm">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
          <i class="fa-solid fa-gauge-high {{ request()->routeIs('dashboard') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
          <span>Dashboard</span>
        </a>

        <a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
          <i class="fa-solid fa-table {{ request()->routeIs('customers.*') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
          <span>Tabel Data</span>
        </a>

        <a href="{{ route('surveys.index') }}" class="{{ request()->routeIs('surveys.*') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
          <i class="fa-solid fa-clipboard-check {{ request()->routeIs('surveys.*') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
          <span>Hasil Survey</span>
        </a>

        <a href="{{ route('materials.index') }}" class="{{ request()->routeIs('materials.*') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
          <i class="fa-solid fa-boxes-stacked {{ request()->routeIs('materials.*') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
          <span>Penyediaan Barang</span>
        </a>

        <a href="{{ route('progress.index') }}" class="{{ request()->routeIs('progress.*') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
          <i class="fa-solid fa-chart-line {{ request()->routeIs('progress.*') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
          <span>Laporan Progres</span>
        </a>
      </nav>

      <div class="mt-auto border-t border-gray-700 px-4 py-4">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="flex w-full items-center justify-center gap-2 rounded-lg bg-gray-700 px-3 py-2 text-gray-300 hover:bg-gray-600 hover:text-white" type="submit">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
          </button>
        </form>
      </div>
    </aside>

    {{-- Sidebar (mobile) --}}
    <div class="lg:hidden" x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40">
      <div class="absolute inset-0 bg-black/40" @click="sidebarOpen = false"></div>

      <aside class="absolute inset-y-0 left-0 z-50 w-72 bg-gray-800 p-4 text-gray-100" x-show="sidebarOpen" x-transition>
        <div class="mb-6 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <i class="fa-solid fa-house-chimney text-2xl text-emerald-400"></i>
            <span class="text-lg font-bold text-white">House Repair</span>
          </div>
          <button class="rounded p-2 hover:bg-gray-700" @click="sidebarOpen = false">
            <i class="fa-solid fa-xmark text-xl"></i>
          </button>
        </div>

        <nav class="space-y-1 text-sm">
          <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
            <i class="fa-solid fa-gauge-high {{ request()->routeIs('dashboard') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
            <span>Dashboard</span>
          </a>
          <a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
            <i class="fa-solid fa-table {{ request()->routeIs('customers.*') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
            <span>Tabel Data</span>
          </a>
          <a href="{{ route('surveys.index') }}" class="{{ request()->routeIs('surveys.*') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
            <i class="fa-solid fa-clipboard-check {{ request()->routeIs('surveys.*') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
            <span>Hasil Survey</span>
          </a>
          <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-300 transition-colors hover:bg-gray-700 hover:text-white">
            <i class="fa-solid fa-boxes-stacked w-5 text-gray-400"></i>
            <span>Penyediaan Barang</span>
          </a>
          <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-300 transition-colors hover:bg-gray-700 hover:text-white">
            <i class="fa-solid fa-chart-line w-5 text-gray-400"></i>
            <span>Laporan Progres</span>
          </a>
        </nav>

        <div class="mt-6">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="flex w-full items-center justify-center gap-2 rounded-lg bg-gray-700 px-3 py-2 text-gray-300 hover:bg-gray-600 hover:text-white" type="submit">
              <i class="fa-solid fa-right-from-bracket"></i>
              <span>Logout</span>
            </button>
          </form>
        </div>
      </aside>
    </div>

    {{-- Main content --}}
    <div class="flex min-w-0 flex-1 flex-col">

      {{-- Topbar --}}
      <header class="flex h-16 items-center justify-between border-b border-gray-200 bg-white px-4 dark:border-gray-700 dark:bg-gray-800 lg:px-8">
        <div class="flex items-center gap-2">
          <button class="rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-700 lg:hidden" @click="sidebarOpen = true">
            <i class="fa-solid fa-bars text-lg"></i>
          </button>
          <h1 class="text-lg font-semibold">@yield('title', 'Dashboard')</h1>
        </div>

        <div class="flex items-center gap-3">
          {{-- Dark/Light switch --}}
          <button @click="darkMode = !darkMode" class="rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-700" :aria-label="darkMode ? 'Switch to light mode' : 'Switch to dark mode'" type="button">
            <i x-show="!darkMode" class="fa-solid fa-moon"></i>
            <i x-show="darkMode" x-cloak class="fa-solid fa-sun text-yellow-300"></i>
          </button>

          {{-- Notification placeholder --}}
          <button class="rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-700">
            <i class="fa-regular fa-bell"></i>
          </button>

          {{-- User --}}
          <div class="flex items-center gap-3">
            <div class="hidden text-right text-sm leading-tight sm:block">
              <div class="font-medium">{{ Auth::user()->name ?? 'User' }}</div>
              <div class="text-gray-500 dark:text-gray-400">{{ Auth::user()->email ?? '' }}</div>
            </div>
            <div class="grid h-9 w-9 place-items-center rounded-full bg-emerald-600 text-white dark:bg-emerald-700">
              <i class="fa-solid fa-user"></i>
            </div>
          </div>
        </div>
      </header>

      {{-- Page content --}}
      <main class="p-4 lg:p-8">
        {{-- Toast --}}
        <x-toast />

        @yield('content')
      </main>
    </div>
  </div>

  {{-- Alpine.js --}}
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <style>
    [x-cloak] {
      display: none !important;
    }
  </style>
</body>

</html>
