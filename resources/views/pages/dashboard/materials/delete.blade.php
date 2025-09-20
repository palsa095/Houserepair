@props(['material'])

<x-modal name="deleteMaterial{{ $material->id }}">
  <div class="p-6">
    <h2 class="mb-4 text-lg font-bold">Konfirmasi Hapus</h2>
    <p>Yakin ingin menghapus <strong>{{ $material->nama }}</strong>?</p>
    <div class="mt-6 flex justify-end">
      <x-secondary-button x-on:click="$dispatch('close')">
        Batal
      </x-secondary-button>

      <form method="POST" action="{{ route('materials.destroy', $material) }}">
        @csrf
        @method('DELETE')
        <x-danger-button class="ml-3">
          Hapus
        </x-danger-button>
      </form>
    </div>
  </div>
</x-modal>
