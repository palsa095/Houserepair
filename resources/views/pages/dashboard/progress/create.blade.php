<x-modal name="createProgres" focusable>
  <form method="POST" action="{{ route('progress.store') }}" enctype="multipart/form-data" class="space-y-4 p-6">
    @csrf
    <h2 class="mb-4 text-lg font-bold">Tambah Progres Baru</h2>

    <div>
      <x-input-label for="customer_id" value="Customer" />
      <select id="customer_id" name="customer_id" required
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        <option value="">Pilih Customer</option>
        @foreach ($customers as $c)
          <option value="{{ $c->id }}" {{ old('customer_id') == $c->id ? 'selected' : '' }}>
            {{ $c->name }} — {{ $c->phone }}
          </option>
        @endforeach
      </select>
      <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="nama" value="Nama" />
      <x-text-input id="nama" class="mt-1 block w-full" type="text" name="nama" :value="old('nama')" required autofocus />
      <x-input-error :messages="$errors->get('nama')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="yang_dikerjakan" value="Yang Dikerjakan" />
      <textarea id="yang_dikerjakan" name="yang_dikerjakan" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('yang_dikerjakan') }}</textarea>
      <x-input-error :messages="$errors->get('yang_dikerjakan')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="bukti_progress" value="Bukti Progres (Foto)" />
      <input type="file" id="bukti_progress" name="bukti_progress[]" multiple accept="image/*" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
      <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: JPEG, PNG, JPG, GIF (Maks 2MB per file)</p>
      <x-input-error :messages="$errors->get('bukti_progress')" class="mt-2" />

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
    document.getElementById('bukti_progress').addEventListener('change', function(e) {
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
