@extends('layouts.app')

@section('title', 'Tabel Data Customer')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
    <div class="flex justify-between items-center mb-4">
        <div class="flex gap-2">
            <input type="text" placeholder="Search" class="border rounded px-3 py-1 dark:bg-gray-700">
            <select class="border rounded px-3 py-1 dark:bg-gray-700">
                <option>Due date</option>
            </select>
        </div>
        <button class="bg-gray-200 dark:bg-gray-700 px-3 py-1 rounded">🖨 Print</button>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th class="p-2 text-left">#</th>
                <th class="p-2 text-left">Nama</th>
                <th class="p-2 text-left">No.Telp</th>
                <th class="p-2 text-left">Alamat</th>
                <th class="p-2 text-left">Kategori</th>
                <th class="p-2 text-left">Keterangan</th>
                <th class="p-2 text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b dark:border-gray-600">
                <td class="p-2">1</td>
                <td class="p-2">Pablo Serban</td>
                <td class="p-2">082847290344</td>
                <td class="p-2">Jalan Kalurang KM. 14, Sleman, Yogyakarta</td>
                <td class="p-2"><span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded">Sedang</span></td>
                <td class="p-2">Atap bocor, dinding retak.</td>
                <td class="p-2">✅ Selesai</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
