@props(['customer'])

<x-modal name="editCustomer{{ $customer->id }}" focusable>
  <form method="POST" action="{{ route('customers.update', $customer) }}">
    <div class="space-y-4 p-6">
      @csrf
      @method('PUT')
      <h2 class="mb-4 text-lg font-bold">Edit Customer</h2>

      <div>
        <x-input-label for="name{{ $customer->id }}" value="Nama" />
        <x-text-input id="name{{ $customer->id }}" name="name" type="text" class="mt-1 block w-full" value="{{ $customer->name }}" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="phone{{ $customer->id }}" value="No. Telp" />
        <x-text-input id="phone{{ $customer->id }}" name="phone" type="text" class="mt-1 block w-full" value="{{ $customer->phone }}" required />
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="address{{ $customer->id }}" value="Alamat" />
        <textarea id="address{{ $customer->id }}" name="address" class="mt-1 block w-full rounded">{{ $customer->address }}</textarea>
        <x-input-error :messages="$errors->get('address')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="category{{ $customer->id }}" value="Kategori" />
        <select id="category{{ $customer->id }}" name="category" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
          <option value="">-- Pilih --</option>
          <option value="Ringan" {{ $customer->category == 'Ringan' ? 'selected' : '' }}>Ringan</option>
          <option value="Sedang" {{ $customer->category == 'Sedang' ? 'selected' : '' }}>Sedang</option>
          <option value="Berat" {{ $customer->category == 'Berat' ? 'selected' : '' }}>Berat</option>
        </select>
        <x-input-error :messages="$errors->get('category')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="note{{ $customer->id }}" value="Keterangan" />
        <textarea id="note{{ $customer->id }}" name="note" class="mt-1 block w-full rounded">{{ $customer->note }}</textarea>
        <x-input-error :messages="$errors->get('note')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="status{{ $customer->id }}" value="Status" />
        <select id="status{{ $customer->id }}" name="status" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
          <option value="">-- Pilih --</option>
          <option value="Tidak diterima" {{ $customer->status == 'Tidak diterima' ? 'selected' : '' }}>Tidak diterima</option>
          <option value="Sedang diproses" {{ $customer->status == 'Sedang diproses' ? 'selected' : '' }}>Sedang diproses</option>
          <option value="Sudah selesai" {{ $customer->status == 'Sudah selesai' ? 'selected' : '' }}>Sudah selesai</option>
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
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
