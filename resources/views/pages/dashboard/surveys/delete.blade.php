@props(['survey'])

<x-modal name="deleteSurvey{{ $survey->id }}">
  <div class="p-6">
    <h2 class="mb-4 text-lg font-bold">Konfirmasi Hapus</h2>
    <p>Yakin ingin menghapus survey <strong>{{ $survey->nama }}</strong>?</p>
    <div class="mt-6 flex justify-end">
      <x-secondary-button x-on:click="$dispatch('close')">
        Batal
      </x-secondary-button>

      <form method="POST" action="{{ route('surveys.destroy', $survey) }}">
        @csrf
        @method('DELETE')
        <x-danger-button class="ml-3">
          Hapus
        </x-danger-button>
      </form>
    </div>
  </div>
</x-modal>
