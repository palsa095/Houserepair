@extends('layouts.landing')

@section('title', 'Address')

@section('content')
  <div class="mx-auto max-w-4xl p-6">
    <h1 class="mb-4 text-2xl font-bold text-emerald-600">Alamat Anda</h1>

    <div class="mb-6 rounded-lg bg-white p-4 shadow ring-1 ring-gray-200">
      <form method="POST" action="{{ route('landing.address.store') }}" class="space-y-4">
        @csrf
        <div>
          <label for="label" class="block text-sm font-medium text-gray-700">Label (opsional)</label>
          <input id="label" name="label" type="text" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('label') }}">
        </div>
        <div>
          <label for="address_line" class="block text-sm font-medium text-gray-700">Alamat</label>
          <textarea id="address_line" name="address_line" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address_line') }}</textarea>
        </div>
        <div class="flex items-center gap-2">
          <input id="is_default" name="is_default" type="checkbox" value="1" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
          <label for="is_default" class="text-sm text-gray-700">Jadikan default</label>
        </div>
        <div>
          <button type="submit" class="rounded bg-black px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">Tambah Alamat</button>
        </div>
      </form>
    </div>

    <div class="rounded-lg bg-white shadow ring-1 ring-gray-200">
      @if (count($addresses))
        <ul class="divide-y divide-gray-100">
          @foreach ($addresses as $addr)
            <li class="px-4 py-3 text-sm">
              <div class="flex items-center justify-between">
                <div>
                  <div class="font-semibold">{{ $addr->label ?? 'Alamat' }}</div>
                  <div class="text-gray-700">{{ $addr->address_line }}</div>
                </div>
                <div class="flex items-center gap-2">
                  @if ($addr->is_default)
                    <label class="inline-flex items-center gap-2">
                      <input type="radio" checked disabled class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                      <span class="rounded bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-700">Default</span>
                    </label>
                  @else
                    <form method="POST" action="{{ route('landing.address.setdefault', $addr) }}">
                      @csrf
                      <label class="inline-flex cursor-pointer items-center gap-2">
                        <input type="radio" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" onchange="this.form.submit()" aria-label="Pilih sebagai default">
                        <span class="text-xs text-gray-700">Jadikan default</span>
                      </label>
                    </form>
                  @endif
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      @else
        <ul class="divide-y divide-gray-100">
          @forelse ($fallback as $fb)
            <li class="px-4 py-3 text-sm">{{ $fb }}</li>
          @empty
            <li class="px-4 py-3 text-sm text-gray-500">Tidak ada alamat tersimpan.</li>
          @endforelse
        </ul>
      @endif
    </div>
  </div>
@endsection
