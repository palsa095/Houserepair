@props(['customer'])

<x-modal name="deleteCustomer{{ $customer->id }}">
  <div class="p-6">
    <h2 class="mb-4 text-lg font-bold">Konfirmasi Hapus</h2>
    <p>Yakin ingin menghapus <strong>{{ $customer->name }}</strong>?</p>
    <div class="mt-6 flex justify-end">
      <x-secondary-button x-on:click="$dispatch('close')">
        Batal
      </x-secondary-button>

      <form method="POST" action="{{ route('customers.destroy', $customer) }}">
        @csrf
        @method('DELETE')
        <x-danger-button class="ml-3">
          Hapus
        </x-danger-button>
      </form>
    </div>
  </div>
</x-modal>
