@extends('layouts.app')

@section('title', 'Data Survey')

@section('content')
  <style>
    .image-preview-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
      gap: 8px;
      margin-top: 8px;
    }
    .image-preview { position: relative; border-radius: 4px; overflow: hidden; width: 70px; }
    .image-preview img { width: 100%; height: 100%; object-fit: cover; }
    .image-count-badge {
      position: absolute; top: 4px; right: 4px;
      background-color: rgba(0,0,0,0.7); color: #fff; border-radius: 50%;
      width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 12px;
    }
    .dark .image-preview { border: 1px solid #374151; }
    .dark .image-count-badge { background-color: rgba(255,255,255,0.7); color: #1f2937; }
  </style>

  <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
    {{-- Search and Filters --}}
    <div class="flex flex-col gap-4 mb-4 md:flex-row md:items-center md:justify-between">
      <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
        {{-- Search Input --}}
        <div class="relative">
          <input
            type="text"
            id="search"
            placeholder="Search..."
            class="block w-full p-2 pl-10 text-sm bg-white border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            value="{{ request('search') }}"
            @if(function_exists('Livewire')) wire:model.live="search" @endif
          >
        </div>

        {{-- Date Range Filter --}}
        <div class="flex items-center gap-2">
          <input type="date" id="startDate" class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-800 dark:text-white" value="{{ request('start_date') }}">
          <span class="text-sm text-gray-500">to</span>
          <input type="date" id="endDate" class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-800 dark:text-white" value="{{ request('end_date') }}">
        </div>

        {{-- Tombol Filter & Reset --}}
        <div class="flex gap-2">
          <button type="button" id="applyFilterSurvey"
                  class="flex items-center p-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="mr-2 fa-solid fa-filter"></i>
          </button>

          <a href="{{ route('surveys.index') }}"
             class="flex items-center p-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="mr-2 fa-solid fa-rotate-left"></i>
          </a>
        </div>
      </div>

      {{-- Action Buttons --}}
      <div class="flex gap-2">
        <button type="button" id="printSurveyBtn"
                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
          <i class="mr-2 fa-solid fa-print"></i> Print
        </button>

        <x-primary-button x-on:click="$dispatch('open-modal', 'createSurvey')">
          <i class="mr-2 fa-solid fa-plus"></i>Tambah
        </x-primary-button>
      </div>
    </div>

    {{-- Table --}}
    @if ($surveys->isEmpty())
      <div class="p-8 text-center border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 dark:border-gray-600 dark:bg-gray-800">
        <i class="text-5xl text-gray-400 fa-solid fa-clipboard-list dark:text-gray-500"></i>
        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Data Survey Kosong</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Belum ada data survey yang tersimpan.</p>
        <div class="mt-6">
          <x-primary-button x-on:click="$dispatch('open-modal', 'createSurvey')">
            <i class="mr-2 fa-solid fa-plus"></i>Tambah Survey Pertama
          </x-primary-button>
        </div>
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse" id="surveyTable">
          <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
              <th class="p-2">#</th>
              <th class="p-2">Nama Survey</th>
              <th class="p-2">Hasil Survey</th>
              <th class="p-2">Dokumentasi</th>
              <th class="p-2">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($surveys as $i => $survey)
              <tr class="border-b dark:border-gray-600">
                <td class="p-2">{{ $i + 1 }}</td>
                <td class="p-2 font-medium">{{ $survey->nama }}</td>
                <td class="max-w-xs p-2 truncate">{{ $survey->hasil_survey }}</td>
                <td class="p-3">
                  @if ($survey->dokumentasi)
                    @php
                      $images = json_decode($survey->dokumentasi, true) ?: [];
                      $count = count($images);
                    @endphp

                    <div x-data="{ showPreview: false }" class="relative">
                      <div @click="showPreview = true" class="cursor-pointer">
                        <div class="image-preview">
                          <img src="{{ asset('storage/' . $images[0]) }}" alt="Preview dokumentasi">
                          @if ($count > 1)
                            <div class="image-count-badge">+{{ $count - 1 }}</div>
                          @endif
                        </div>
                      </div>

                      <div x-show="showPreview" x-transition
                           class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-75"
                           @click.away="showPreview = false" x-trap.noscroll="showPreview">
                        <div class="relative max-h-[90vh] w-full max-w-4xl overflow-auto rounded-lg bg-white shadow-xl dark:bg-gray-800">
                          <button @click="showPreview = false" class="absolute text-gray-500 right-4 top-4 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100">
                            <i class="text-2xl fa-solid fa-xmark"></i>
                          </button>

                          <div class="p-6">
                            <h3 class="mb-4 text-lg font-semibold dark:text-white">Dokumentasi Survey</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                              @foreach ($images as $image)
                                <div class="overflow-hidden border rounded dark:border-gray-600">
                                  <img src="{{ asset('storage/' . $image) }}" alt="Dokumentasi survey" class="object-cover w-full h-48">
                                  <div class="p-2 text-center bg-gray-50 dark:bg-gray-700">
                                    <a href="{{ asset('storage/' . $image) }}" download class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                      <i class="mr-1 fa-solid fa-download"></i> Download
                                    </a>
                                  </div>
                                </div>
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  @else
                    <span class="text-gray-500">Tidak ada</span>
                  @endif
                </td>
                <td class="flex gap-2 p-2">
                  <button type="button" class="text-yellow-500 hover:text-yellow-700" @click="$dispatch('open-modal', 'editSurvey{{ $survey->id }}')">
                    <i class="fa-solid fa-pen"></i>
                  </button>
                  <button type="button" class="text-red-500 hover:text-red-700" @click="$dispatch('open-modal', 'deleteSurvey{{ $survey->id }}')">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      @if ($surveys->hasPages())
        <div class="mt-4">
          {{ $surveys->links() }}
        </div>
      @endif
    @endif
  </div>

  {{-- Include Modals --}}
  @include('pages.dashboard.surveys.create')
  @foreach ($surveys as $survey)
    @include('pages.dashboard.surveys.edit', ['survey' => $survey])
    @include('pages.dashboard.surveys.delete', ['survey' => $survey])
  @endforeach
@endsection

@push('scripts')
<script>
  // ====== FILTER ======
  function applyFilterSurveys() {
    try {
      const searchInput = document.getElementById('search');
      const startDate   = document.getElementById('startDate');
      const endDate     = document.getElementById('endDate');

      const params = new URLSearchParams();
      if (searchInput && searchInput.value) params.set('search', searchInput.value);
      if (startDate && endDate && startDate.value && endDate.value) {
        params.set('start_date', startDate.value);
        params.set('end_date',   endDate.value);
      }

      window.location.href = `${window.location.pathname}?${params.toString()}`;
    } catch (e) { console.error('applyFilterSurveys error:', e); }
  }

  // ====== PRINT ======
  function printSurveyTable() {
    try {
      const printWindow = window.open('', '', 'height=600,width=800');
      printWindow.document.write('<html><head><title>Data Survey</title>');
      printWindow.document.write('<style>');
      printWindow.document.write(`
        body { font-family: Arial, sans-serif; margin: 1cm; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
        .date { text-align: right; margin-bottom: 10px; font-size: 0.9em; }
      `);
      printWindow.document.write('</style>');
      printWindow.document.write('</head><body>');

      printWindow.document.write('<div class="header"><h2>Data Survey</h2></div>');
      printWindow.document.write(`<div class="date">Printed on: ${new Date().toLocaleDateString('id-ID', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
      })}</div>`);

      const table = document.createElement('table');
      const thead = document.createElement('thead');
      const tbody = document.createElement('tbody');

      const headerRow = document.createElement('tr');
      ['No', 'Nama Survey', 'Hasil Survey', 'Dokumentasi'].forEach(text => {
        const th = document.createElement('th'); th.textContent = text; headerRow.appendChild(th);
      });
      thead.appendChild(headerRow); table.appendChild(thead);

      @foreach ($surveys as $i => $survey)
        (function() {
          const row = document.createElement('tr');
          const cells = [
            {{ $i + 1 }},
            @json($survey->nama),
            @json($survey->hasil_survey),
            @json($survey->dokumentasi ? (count(json_decode($survey->dokumentasi)) . ' foto') : 'Tidak ada'),
          ];
          cells.forEach(text => { const td = document.createElement('td'); td.textContent = text; row.appendChild(td); });
          tbody.appendChild(row);
        })();
      @endforeach

      table.appendChild(tbody);
      printWindow.document.write(table.outerHTML);
      printWindow.document.write('</body></html>');
      printWindow.document.close(); printWindow.focus();
      setTimeout(() => { printWindow.print(); printWindow.close(); }, 300);
    } catch (e) { console.error('printSurveyTable error:', e); }
  }

  // ====== BIND HANDLERS ======
  function bindSurveyPageHandlers() {
    const btnFilter = document.getElementById('applyFilterSurvey');
    if (btnFilter) btnFilter.onclick = applyFilterSurveys;

    const inputSearch = document.getElementById('search');
    if (inputSearch) inputSearch.onkeydown = (e)=>{ if (e.key === 'Enter') applyFilterSurveys(); };

    const btnPrint = document.getElementById('printSurveyBtn');
    if (btnPrint) btnPrint.onclick = printSurveyTable;
  }

  // Ekspor global (opsional)
  window.applyFilterSurveys = applyFilterSurveys;
  window.printSurveyTable   = printSurveyTable;

  // Bind awal dan setelah wire:navigate (Livewire v3)
  document.addEventListener('DOMContentLoaded', bindSurveyPageHandlers);
  document.addEventListener('livewire:navigated', bindSurveyPageHandlers);
</script>
@endpush
