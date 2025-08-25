<x-modal name="createSurvey" focusable>
  <form method="POST" action="{{ route('surveys.store') }}" enctype="multipart/form-data" class="space-y-4 p-6">
    @csrf
    <h2 class="mb-4 text-lg font-bold">Tambah Survey Baru</h2>

    <div>
      <x-input-label for="nama" value="Nama Survey" />
      <x-text-input id="nama" class="mt-1 block w-full" type="text" name="nama" :value="old('nama')" required autofocus />
      <x-input-error :messages="$errors->get('nama')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="hasil_survey" value="Hasil Survey" />
      <textarea id="hasil_survey" name="hasil_survey" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('hasil_survey') }}</textarea>
      <x-input-error :messages="$errors->get('hasil_survey')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="dokumentasi" value="Dokumentasi (Foto)" />
      <input type="file" id="dokumentasi" name="dokumentasi[]" multiple accept="image/*" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
      <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: JPEG, PNG, JPG, GIF (Maks 2MB per file)</p>
      <x-input-error :messages="$errors->get('dokumentasi')" class="mt-2" />

      <!-- Preview container -->
      <div id="imagePreview" class="mt-2 grid grid-cols-3 gap-2"></div>
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

  <script>
    document.getElementById('dokumentasi').addEventListener('change', function(e) {
      const preview = document.getElementById('imagePreview');
      preview.innerHTML = '';

      if (this.files) {
        Array.from(this.files).forEach(file => {
          if (file.type.match('image.*')) {
            const reader = new FileReader();

            reader.onload = function(e) {
              const img = document.createElement('img');
              img.src = e.target.result;
              img.className = 'w-full object-cover rounded border border-gray-200 dark:border-gray-600';
              preview.appendChild(img);
            }

            reader.readAsDataURL(file);
          }
        });
      }
    });
  </script>
</x-modal>
