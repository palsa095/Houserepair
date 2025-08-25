@extends('layouts.landing')

@section('title', 'About')

@section('content')
  <div class="relative">
    <img src="{{ asset('img/hero-bg.png') }}" alt="Gereja" class="h-[691px] w-full object-cover" />
  </div>

  <div class="mb-[300px]">
    <h1>About</h1>
  </div>
@endsection
