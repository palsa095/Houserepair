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
  <title>House Repair - @yield('title', config('app.name', 'House Repair'))</title>

  {{-- Font Awesome --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  {{-- Vite (Tailwind + JS) --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased text-gray-900 bg-gray-50 dark:bg-gray-900 dark:text-gray-100">
  @php
    $role = Auth::user()->role ?? 'customer';
    $menuPermissions = [
        'super_admin' => ['dashboard', 'customers', 'surveys', 'materials', 'progress', 'invoices'],
        'customer' => ['dashboard'],
        'admin_surveyor' => ['dashboard', 'surveys', 'materials', 'progress'],
        'admin_supplier' => ['dashboard', 'materials', 'surveys', 'progress'],
        'admin_tukang' => ['dashboard', 'progress', 'surveys', 'materials'],
    ];
    $allowed = $menuPermissions[$role] ?? ['dashboard'];

    $showDashboard = in_array('dashboard', $allowed, true);
    $showCustomers = in_array('customers', $allowed, true);
    $showSurveys = in_array('surveys', $allowed, true);
    $showMaterials = in_array('materials', $allowed, true);
    $showProgress = in_array('progress', $allowed, true);
    $showInvoices = in_array('invoices', $allowed, true);
  @endphp

  {{-- Wrapper --}}
  <div class="flex min-h-screen">

    {{-- Sidebar (desktop) --}}
    <aside class="hidden text-gray-100 bg-gray-800 lg:flex lg:w-64 lg:shrink-0 lg:flex-col">
      <div class="flex items-center h-20 gap-3 px-6 border-b border-gray-700">
        <div><img src="{{ asset('/logo.png') }}" /></div>
      </div>

      <nav class="flex-1 px-3 py-4 space-y-1 text-sm">
        @if ($showDashboard)
          <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
            <i class="fa-solid fa-gauge-high {{ request()->routeIs('dashboard') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
            <span>Dashboard</span>
          </a>
        @endif

        @if ($showCustomers)
          <a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
            <i class="fa-solid fa-table {{ request()->routeIs('customers.*') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
            <span>Data Customer</span>
          </a>
        @endif

        @if ($showSurveys)
          <a href="{{ route('surveys.index') }}" class="{{ request()->routeIs('surveys.*') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
            <i class="fa-solid fa-clipboard-check {{ request()->routeIs('surveys.*') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
            <span>Hasil Survey</span>
          </a>
        @endif

        @if ($showMaterials)
          <a href="{{ route('materials.index') }}" class="{{ request()->routeIs('materials.*') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
            <i class="fa-solid fa-boxes-stacked {{ request()->routeIs('materials.*') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
            <span>Penyediaan Barang</span>
          </a>
        @endif

        @if ($showProgress)
          <a href="{{ route('progress.index') }}" class="{{ request()->routeIs('progress.*') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
            <i class="fa-solid fa-chart-line {{ request()->routeIs('progress.*') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
            <span>Laporan Progres</span>
          </a>
        @endif

        @if ($showInvoices)
          <a href="{{ route('invoices.index') }}" class="{{ request()->routeIs('invoices.*') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
            <i class="fa-solid fa-file-invoice-dollar {{ request()->routeIs('invoices.*') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
            <span>Invoice</span>
          </a>
        @endif
      </nav>

      <div class="px-4 py-4 mt-auto border-t border-gray-700">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="flex items-center justify-center w-full gap-2 px-3 py-2 text-gray-300 bg-gray-700 rounded-lg hover:bg-gray-600 hover:text-white" type="submit">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
          </button>
        </form>
      </div>
    </aside>

    {{-- Sidebar (mobile) --}}
    <div class="lg:hidden" x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40">
      <div class="absolute inset-0 bg-black/40" @click="sidebarOpen = false"></div>

      <aside class="absolute inset-y-0 left-0 z-50 p-4 text-gray-100 bg-gray-800 w-72" x-show="sidebarOpen" x-transition>
        <div class="flex items-center justify-between mb-6">
          <div class="flex items-center gap-3">
            <i class="text-2xl fa-solid fa-house-chimney text-emerald-400"></i>
            <span class="text-lg font-bold text-white">House Repair</span>
          </div>
          <button class="p-2 rounded hover:bg-gray-700" @click="sidebarOpen = false">
            <i class="text-xl fa-solid fa-xmark"></i>
          </button>
        </div>

        <nav class="space-y-1 text-sm">
          @if ($showDashboard)
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
              <i class="fa-solid fa-gauge-high {{ request()->routeIs('dashboard') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
              <span>Dashboard</span>
            </a>
          @endif

          @if ($showCustomers)
            <a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
              <i class="fa-solid fa-table {{ request()->routeIs('customers.*') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
              <span>Tabel Data</span>
            </a>
          @endif

          @if ($showSurveys)
            <a href="{{ route('surveys.index') }}" class="{{ request()->routeIs('surveys.*') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
              <i class="fa-solid fa-clipboard-check {{ request()->routeIs('surveys.*') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
              <span>Hasil Survey</span>
            </a>
          @endif

          @if ($showMaterials)
            <a href="{{ route('materials.index') }}" class="{{ request()->routeIs('materials.*') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
              <i class="fa-solid fa-boxes-stacked {{ request()->routeIs('materials.*') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
              <span>Penyediaan Barang</span>
            </a>
          @endif

          @if ($showProgress)
            <a href="{{ route('progress.index') }}" class="{{ request()->routeIs('progress.*') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
              <i class="fa-solid fa-chart-line {{ request()->routeIs('progress.*') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
              <span>Laporan Progres</span>
            </a>
          @endif

          @if ($showInvoices)
            <a href="{{ route('invoices.index') }}" class="{{ request()->routeIs('invoices.*') ? 'bg-gray-700 text-emerald-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
              <i class="fa-solid fa-file-invoice-dollar {{ request()->routeIs('invoices.*') ? 'text-emerald-400' : 'text-gray-400' }} w-5"></i>
              <span>Invoice</span>
            </a>
          @endif
        </nav>

        <div class="mt-6">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="flex items-center justify-center w-full gap-2 px-3 py-2 text-gray-300 bg-gray-700 rounded-lg hover:bg-gray-600 hover:text-white" type="submit">
              <i class="fa-solid fa-right-from-bracket"></i>
              <span>Logout</span>
            </button>
          </form>
        </div>
      </aside>
    </div>

    {{-- Main content --}}
    <div class="flex flex-col flex-1 min-w-0">

      {{-- Topbar --}}
      <header class="flex items-center justify-between h-16 px-4 bg-white border-b border-gray-200 dark:border-gray-700 dark:bg-gray-800 lg:px-8">
        <div class="flex items-center gap-2">
          <button class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 lg:hidden" @click="sidebarOpen = true">
            <i class="text-lg fa-solid fa-bars"></i>
          </button>
          <h1 class="text-lg font-semibold">@yield('title', 'Dashboard')</h1>
        </div>

        <div class="flex items-center gap-3">
          {{-- Dark/Light switch --}}
          <button @click="darkMode = !darkMode" class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700" :aria-label="darkMode ? 'Switch to light mode' : 'Switch to dark mode'" type="button">
            <i x-show="!darkMode" class="fa-solid fa-moon"></i>
            <i x-show="darkMode" x-cloak class="text-yellow-300 fa-solid fa-sun"></i>
          </button>

          {{-- Notification placeholder --}}
          <button class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
            <i class="fa-regular fa-bell"></i>
          </button>

          {{-- User --}}
          <div class="flex items-center gap-3">
            <div class="hidden text-sm leading-tight text-right sm:block">
              <div class="font-medium">{{ Auth::user()->name ?? 'User' }}</div>
              <div class="text-gray-500 dark:text-gray-400">{{ Auth::user()->email ?? '' }}</div>
            </div>
            <div class="grid text-white rounded-full h-9 w-9 place-items-center bg-emerald-600 dark:bg-emerald-700">
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
  @stack('scripts')
</body>

</html>
