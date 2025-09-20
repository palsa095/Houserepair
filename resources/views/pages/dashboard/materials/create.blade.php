<x-modal name="createMaterial" focusable>
  <form method="POST" action="{{ route('materials.store') }}" class="space-y-4 p-6">
    @csrf
    <h2 class="mb-4 text-lg font-bold">Tambah Barang</h2>

    <div>
      <x-input-label for="survey_id" value="Survey" />
      <select id="survey_id" name="survey_id" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        <option value="">-- Pilih --</option>
        @foreach ($surveys as $survey)
          <option value="{{ $survey->id }}" {{ old('survey_id') == $survey->id ? 'selected' : '' }}>{{ $survey->nama }}</option>
        @endforeach
      </select>
      <x-input-error :messages="$errors->get('survey_id')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="keterangan" value="Keterangan" />
      <textarea id="keterangan" name="keterangan" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('keterangan') }}</textarea>
      <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="keperluan_barang" value="Keperluan Barang" />
      <textarea id="keperluan_barang" name="keperluan_barang" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('keperluan_barang') }}</textarea>
      <x-input-error :messages="$errors->get('keperluan_barang')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="total_harga" value="Total Harga" />
      <x-text-input id="total_harga" class="mt-1 block w-full" type="number" name="total_harga" :value="old('total_harga')" required autofocus />
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
  </form>
</x-modal>
