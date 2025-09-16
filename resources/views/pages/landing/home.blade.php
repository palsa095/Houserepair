@extends('layouts.landing')

@section('title', 'Home')

@section('content')
  <div class="relative">
    <img src="{{ asset('img/hero-bg.png') }}" alt="Gereja" class="h-[691px] w-full object-cover" />
  </div>

  <!-- House Repair -->
  <div class="min-h-screen bg-gray-50 py-10 text-slate-800">
    <div class="mx-auto w-full max-w-6xl px-4">

      {{-- HERO --}}
      <div class="mb-10 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
        <div class="flex flex-col items-start justify-between gap-6 md:flex-row md:items-center">
          <div>
            <div class="mb-2 flex items-center gap-2 text-emerald-600">
              <span class="text-xl">✦ ✦</span>
              <span class="text-sm">Reliable fix, clean finish</span>
            </div>
            <h1 class="text-3xl font-extrabold text-emerald-700 md:text-4xl">House Repair</h1>
            <p class="mt-1 max-w-2xl text-sm text-slate-500">
              Semua penjelasan tentang perusahaan kami, disiplin, dan cara bekerja.
            </p>
          </div>

          <a href="/about" class="inline-flex items-center justify-center rounded-full bg-black px-5 py-2.5 text-sm font-semibold text-white shadow hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-emerald-400">
            Let’s see more about profile!
          </a>
        </div>
      </div>

      {{-- DATA dinamis (opsional) --}}
      @php
        // ganti dengan data dari controller bila perlu
        $sections = [
            [
                'title' => 'What is Lorem Ipsum?',
                'text' =>
                    'Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s...' .
                    ' It has survived not only five centuries, but also the leap into electronic typesetting. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s...' .
                    ' It has survived not only five centuries, but also the leap into electronic typesetting.',
                'image' => asset('img/repair-1.png'),
            ],
            [
                'title' => 'Why do we use it?',
                'text' =>
                    'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout...' .
                    ' Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s...' .
                    ' It has survived not only five centuries, but also the leap into electronic typesetting.',
                'image' => asset('img/repair-2.png'),
            ],
            [
                'title' => 'Where can I get some?',
                'text' =>
                    'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration...' .
                    ' The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s...' .
                    ' It has survived not only five centuries, but also the leap into electronic typesetting.',
                'image' => asset('img/repair-3.png'),
            ],
        ];
      @endphp

      {{-- SECTIONS zig-zag --}}
      <div id="profile" class="space-y-8">
        @foreach ($sections as $i => $s)
          @php $even = $i % 2 === 1; @endphp

          <section class="grid items-center gap-6 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-100 md:grid-cols-2 md:p-6">
            {{-- IMAGE (1:1) --}}
            <div class="{{ $even ? 'md:order-2' : 'md:order-1' }} order-1">
              <div class="relative w-full overflow-hidden rounded-xl bg-gray-200 pb-[100%]">
                <img src="{{ $s['image'] }}" alt="{{ $s['title'] }}" class="absolute inset-0 h-full w-full object-cover" />
              </div>
            </div>

            {{-- TEXT --}}
            <div class="{{ $even ? 'md:order-1' : 'md:order-2' }} order-2">
              <div class="mx-auto max-w-xl">
                <div class="mb-2 inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-100">
                  <span>★</span> House Repair
                </div>

                <h2 class="text-xl font-extrabold md:text-2xl">{{ $s['title'] }}</h2>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $s['text'] }}</p>
              </div>
            </div>
          </section>
        @endforeach
      </div>

      {{-- Header + CTA --}}
      <div class="my-6 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
        <div>
          <div class="mb-1 flex items-center gap-2 text-emerald-600">
            <span>✦ ✦</span>
            <span class="text-xs">Rumah rapi dan nyaman? Serahkan renovasimu pada kami!</span>
          </div>
          <h1 class="text-3xl font-extrabold text-emerald-700">Order</h1>
        </div>

        <a href="{{ route('landing.order') }}" class="inline-flex items-center justify-center rounded-full bg-black px-5 py-2 text-sm font-semibold text-white shadow hover:bg-gray-700">
          Let’s Order For Your Renovation!
        </a>
      </div>

      @php
        // bisa kirim dari controller: $packages = [...]
        $packages = $packages ?? [['title' => 'Paket Besar', 'img' => asset('img/paket-1.png')], ['title' => 'Paket Sedang', 'img' => asset('img/paket-2.png')], ['title' => 'Paket Kecil', 'img' => asset('img/paket-3.png')]];
        $desc =
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s...' .
            ' It has survived not only five centuries, but also the leap into electronic typesetting. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s...' .
            ' It has survived not only five centuries, but also the leap into electronic typesetting.' .
            'It has survived not only five centuries, but also the leap into electronic typesetting. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s...' .
            ' It has survived not only five centuries, but also the leap into electronic typesetting.';
      @endphp

      {{-- List cards --}}
      <div class="space-y-4">
        @foreach ($packages as $p)
          <article class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-100">
            {{-- PERBESAR: ubah lebar kolom pertama --}}
            <div class="grid grid-cols-[160px_1fr] items-center gap-5 sm:grid-cols-[220px_1fr] lg:grid-cols-[260px_1fr]">
              {{-- Image 1:1 lebih besar --}}
              <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200">
                <img src="{{ $p['img'] }}" alt="{{ $p['title'] }}" class="absolute inset-0 h-full w-full object-cover" />
              </div>

              <div>
                <h2 class="mb-1 text-2xl font-extrabold">{{ $p['title'] }}</h2>
                <p class="text-sm leading-relaxed text-slate-600">{{ $desc }}</p>
              </div>
            </div>
          </article>
        @endforeach
      </div>

      <div class="mt-10">
        <div class="mb-1 flex items-center gap-2 text-emerald-600">
          <span>✦ ✦</span>
          <span class="text-xs">Akses invoice anda pada halaman ini</span>
        </div>
        <div class="flex flex-col items-start justify-between gap-4 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-100 sm:flex-row sm:items-center">
          <h3 class="text-3xl font-extrabold text-emerald-700">Invoice</h3>
          <a href="{{ route('landing.invoice') }}" class="inline-flex items-center justify-center rounded-full bg-black px-5 py-2 text-sm font-semibold text-white shadow hover:bg-gray-700">
            Let’s See Your Invoice!
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
