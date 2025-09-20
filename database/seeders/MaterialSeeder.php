<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nama' => 'Pengadaan Laptop',
                'keterangan' => 'Pengadaan 10 unit laptop untuk karyawan baru',
                'keperluan_barang' => 'Peralatan kerja karyawan',
                'total_harga' => 75000000
            ],
            [
                'nama' => 'Pembelian Printer',
                'keterangan' => 'Printer laserjet warna untuk divisi marketing',
                'keperluan_barang' => 'Mencetak materi promosi',
                'total_harga' => 4500000
            ],
            [
                'nama' => 'Pengadaan Meja Kerja',
                'keterangan' => 'Meja kerja ergonomis untuk ruang kerja baru',
                'keperluan_barang' => 'Furnitur kantor',
                'total_harga' => 12000000
            ],
            [
                'nama' => 'Pembelian Software',
                'keterangan' => 'Lisensi software design untuk tim kreatif',
                'keperluan_barang' => 'Alat kerja desainer',
                'total_harga' => 8500000
            ],
            [
                'nama' => 'Maintenance AC',
                'keterangan' => 'Service rutin AC seluruh kantor',
                'keperluan_barang' => 'Perawatan fasilitas',
                'total_harga' => 3500000
            ],
        ];

        DB::table('materials')->insert($data);
    }
}
