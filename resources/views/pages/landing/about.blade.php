@extends('layouts.landing')

@section('title', 'About')

@section('content')
  <div class="relative">
    <img src="{{ asset('img/hero-bg.png') }}" alt="Gereja" class="h-[691px] w-full object-cover" />
  </div>

  <div class="mb-[300px] mt-5 max-w-6xl mx-auto px-2">
    <div class="text-gray-800 text-center font-bold my-2">
        <span class="text-2xl">✦</span>
        <span class="text-xl">✦</span>
        <span class="text-lg">✦</span>
        <span class="text-xl">✦</span>
        <span class="text-2xl">✦</span>
    </div>
    <h1 class="text-4xl font-bold text-center">About Us</h1>
    <p class="text-justify text-lg my-4">              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
  </div>
@endsection
