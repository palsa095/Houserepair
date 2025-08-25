<x-modal name="createCustomer" focusable>
  <form method="POST" action="{{ route('customers.store') }}" class="space-y-4 p-6">
    @csrf
    <h2 class="mb-4 text-lg font-bold">Tambah Customer</h2>

    <div>
      <x-input-label for="name" value="Nama" />
      <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')" required autofocus />
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="phone" value="No. Telp" />
      <x-text-input id="phone" class="mt-1 block w-full" type="text" name="phone" :value="old('phone')" required />
      <x-input-error :messages="$errors->get('phone')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="address" value="Alamat" />
      <textarea id="address" name="address" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('address') }}</textarea>
      <x-input-error :messages="$errors->get('address')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="category" value="Kategori" />
      <x-text-input id="category" class="mt-1 block w-full" type="text" name="category" :value="old('category')" required autofocus />
      <x-input-error :messages="$errors->get('category')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="note" value="Keterangan" />
      <textarea id="note" name="note" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('note') }}</textarea>
      <x-input-error :messages="$errors->get('note')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="status" value="Status" />
      <select id="status" name="status" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        <option value="">-- Pilih --</option>
        <option value="Tidak diterima" {{ old('status') == 'Tidak diterima' ? 'selected' : '' }}>Tidak diterima</option>
        <option value="Sedang diproses" {{ old('status') == 'Sedang diproses' ? 'selected' : '' }}>Sedang diproses</option>
        <option value="Sudah selesai" {{ old('status') == 'Sudah selesai' ? 'selected' : '' }}>Sudah selesai</option>
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
  </form>
</x-modal>
