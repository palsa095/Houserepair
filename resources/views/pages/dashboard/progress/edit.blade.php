@props(['progres'])

<x-modal name="editProgres{{ $progres->id }}" focusable>
  <form method="POST" action="{{ route('progress.update', $progres) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="space-y-4 p-6">
      <h2 class="mb-4 text-lg font-bold">Edit Progres</h2>

      <div>
        <x-input-label for="nama{{ $progres->id }}" value="Nama" />
        <x-text-input id="nama{{ $progres->id }}" name="nama" type="text" class="mt-1 block w-full" value="{{ $progres->nama }}" required />
        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="yang_dikerjakan{{ $progres->id }}" value="Yang Dikerjakan" />
        <textarea id="yang_dikerjakan{{ $progres->id }}" name="yang_dikerjakan" class="mt-1 block w-full rounded">{{ $progres->yang_dikerjakan }}</textarea>
        <x-input-error :messages="$errors->get('yang_dikerjakan')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="bukti_progress{{ $progres->id }}" value="Bukti Progres (Foto)" />
        <input type="file" id="bukti_progress{{ $progres->id }}" name="bukti_progress[]" multiple accept="image/*" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Biarkan kosong jika tidak ingin mengubah foto</p>
        <x-input-error :messages="$errors->get('bukti_progress')" class="mt-2" />

        <!-- Existing images -->
        <div class="mt-2 grid grid-cols-3 gap-2">
          @if ($progres->bukti_progress)
            @foreach (json_decode($progres->bukti_progress) as $image)
              <div class="relative">
                <img src="{{ asset('storage/' . $image) }}" class="w-full rounded border border-gray-200 object-cover dark:border-gray-600">
                <input type="hidden" name="existing_images[]" value="{{ $image }}">
              </div>
            @endforeach
          @endif
        </div>
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
