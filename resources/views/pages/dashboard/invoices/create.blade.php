<x-modal name="createInvoice" focusable>
  <form method="POST" action="{{ route('invoices.store') }}" class="space-y-4 p-6" x-data="invoiceFormCreate()">
    @csrf
    <h2 class="mb-4 text-lg font-bold">Tambah Invoice</h2>

    <div class="grid gap-4 sm:grid-cols-2">
      <div>
        <x-input-label for="number" value="Nomor Invoice" />
        <x-text-input id="number" name="number" class="mt-1 block w-full" type="text" :value="old('number')" required />
        <x-input-error :messages="$errors->get('number')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="date" value="Tanggal" />
        <x-text-input id="date" name="date" class="mt-1 block w-full" type="date" :value="old('date', now()->toDateString())" required />
        <x-input-error :messages="$errors->get('date')" class="mt-2" />
      </div>

      <div class="sm:col-span-2">
        <x-input-label for="customer_name" value="Nama Pelanggan" />
        <x-text-input id="customer_name" name="customer_name" class="mt-1 block w-full" type="text" :value="old('customer_name')" required />
        <x-input-error :messages="$errors->get('customer_name')" class="mt-2" />
      </div>

      <div class="sm:col-span-2">
        <x-input-label for="customer_address" value="Alamat" />
        <textarea id="customer_address" name="customer_address" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('customer_address') }}</textarea>
        <x-input-error :messages="$errors->get('customer_address')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="customer_phone" value="Telepon" />
        <x-text-input id="customer_phone" name="customer_phone" class="mt-1 block w-full" type="text" :value="old('customer_phone')" />
        <x-input-error :messages="$errors->get('customer_phone')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="currency" value="Mata Uang" />
        <x-text-input id="currency" name="currency" class="mt-1 block w-full" type="text" :value="old('currency', 'Rp')" required />
        <x-input-error :messages="$errors->get('currency')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="package" value="Paket (opsional)" />
        <x-text-input id="package" name="package" class="mt-1 block w-full" type="text" :value="old('package')" />
        <x-input-error :messages="$errors->get('package')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="project" value="Proyek (opsional)" />
        <x-text-input id="project" name="project" class="mt-1 block w-full" type="text" :value="old('project')" />
        <x-input-error :messages="$errors->get('project')" class="mt-2" />
      </div>
    </div>

    {{-- Items --}}
    <div class="mt-4">
      <div class="mb-2 flex items-center justify-between">
        <h3 class="font-semibold">Item</h3>
        <x-primary-button type="button" x-on:click="add()">+ Item</x-primary-button>
      </div>

      <div class="overflow-hidden rounded-lg border">
        <table class="w-full text-sm">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th class="px-3 py-2">#</th>
              <th class="px-3 py-2">Judul</th>
              <th class="px-3 py-2">Deskripsi</th>
              <th class="px-3 py-2 text-right">Subtotal</th>
              <th class="px-3 py-2"></th>
            </tr>
          </thead>
          <tbody>
            <template x-for="(row,i) in items" :key="i">
              <tr class="border-t dark:border-gray-700">
                <td class="px-3 py-2" x-text="i+1"></td>
                <td class="px-3 py-2">
                  <input class="w-full rounded border px-2 py-1" :name="`items[${i}][title]`" x-model="row.title" required>
                </td>
                <td class="px-3 py-2">
                  <input class="w-full rounded border px-2 py-1" :name="`items[${i}][description]`" x-model="row.description">
                </td>
                <td class="px-3 py-2">
                  <input class="w-full rounded border px-2 py-1 text-right" type="number" step="0.01" min="0" :name="`items[${i}][subtotal]`" x-model.number="row.subtotal" required>
                </td>
                <td class="px-3 py-2 text-right">
                  <button type="button" class="text-red-600" x-on:click="remove(i)">✕</button>
                </td>
              </tr>
            </template>
          </tbody>
          <tfoot class="bg-gray-50 dark:bg-gray-800">
            <tr>
              <td colspan="3" class="px-3 py-2 text-right font-semibold">Total</td>
              <td class="px-3 py-2 text-right font-semibold" x-text="formatIDR(total())"></td>
              <td></td>
            </tr>
          </tfoot>
        </table>
      </div>

      {{-- server-side errors for items --}}
      @error('items')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
      @enderror
      @error('items.*.title')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
      @enderror
      @error('items.*.subtotal')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <div class="mt-6 flex justify-end">
      <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
      <x-primary-button class="ml-3">Simpan</x-primary-button>
    </div>
  </form>
</x-modal>

<script>
  function invoiceFormCreate() {
    return {
      items: @js(old('items', [['title' => '', 'description' => '', 'subtotal' => 0]])),
      add() {
        this.items.push({
          title: '',
          description: '',
          subtotal: 0
        });
      },
      remove(i) {
        this.items.splice(i, 1);
        if (this.items.length === 0) this.add();
      },
      total() {
        return this.items.reduce((a, b) => a + (parseFloat(b.subtotal) || 0), 0);
      },
      formatIDR(n) {
        return new Intl.NumberFormat('id-ID').format(n);
      }
    }
  }
</script>
