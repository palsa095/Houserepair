@extends('layouts.app')

@section('title', 'Tabel Data Customer')

@section('content')
  {{-- CONTENT --}}
  <main class="px-6 pb-10">
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
      {{-- Card 1 --}}
      <div class="h-40 rounded-2xl bg-slate-200"></div>
      {{-- Card 2 --}}
      <div class="h-40 rounded-2xl bg-slate-200"></div>
      {{-- Card 3 --}}
      <div class="h-40 rounded-2xl bg-slate-200"></div>
    </div>
  </main>
@endsection
