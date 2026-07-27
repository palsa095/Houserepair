@props(['material'])

<x-modal name="editMaterial{{ $material->id }}" focusable>
  <form method="POST" action="{{ route('materials.update', $material) }}">
    <div class="space-y-4 p-6">
      @csrf
      @method('PUT')
      <h2 class="mb-4 text-lg font-bold">Edit Barang</h2>

      <div>
        <x-input-label for="customer_id{{ $material->id }}" value="Customer" />
        <select id="customer_id{{ $material->id }}" name="customer_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
          <option value="">Pilih Customer</option>
          @foreach ($customers as $c)
            <option value="{{ $c->id }}" {{ $material->customer_id == $c->id ? 'selected' : '' }}>
              {{ $c->name }} — {{ $c->phone }}
            </option>
          @endforeach
        </select>
        <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="nama{{ $material->id }}" value="Nama" />
        <x-text-input id="nama{{ $material->id }}" name="nama" type="text" class="mt-1 block w-full" value="{{ $material->nama }}" required />
        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="keterangan{{ $material->id }}" value="keterangan" />
        <textarea id="keterangan{{ $material->id }}" name="keterangan" class="mt-1 block w-full rounded">{{ $material->keterangan }}</textarea>
        <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="keperluan_barang{{ $material->id }}" value="keperluan_barang" />
        <textarea id="keperluan_barang{{ $material->id }}" name="keperluan_barang" class="mt-1 block w-full rounded">{{ $material->keperluan_barang }}</textarea>
        <x-input-error :messages="$errors->get('keperluan_barang')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="total_harga{{ $material->id }}" value="Total Harga" />
        <x-text-input id="total_harga{{ $material->id }}" name="total_harga" type="number" class="mt-1 block w-full" value="{{ $material->total_harga }}" required />
        <x-input-error :messages="$errors->get('total_harga')" class="mt-2" />
      </div>

      <div class="mt-6 flex justify-end">
        <x-secondary-button x-on:click="$dispatch('close')">
          Batal
        </x-secondary-button>

        <x-primary-button class="ml-3">
          Simpan
        </x-primary-button>
      </div>
    </div>
  </form>
</x-modal>
