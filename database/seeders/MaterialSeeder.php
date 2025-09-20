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
                'survey_id' => 1,
                'keterangan' => 'Pengadaan 10 unit laptop untuk karyawan baru',
                'keperluan_barang' => 'Peralatan kerja karyawan',
                'total_harga' => 75000000
            ],
            [
                'survey_id' => 2,
                'keterangan' => 'Printer laserjet warna untuk divisi marketing',
                'keperluan_barang' => 'Mencetak materi promosi',
                'total_harga' => 4500000
            ],
            [
                'survey_id' => 3,
                'keterangan' => 'Meja kerja ergonomis untuk ruang kerja baru',
                'keperluan_barang' => 'Furnitur kantor',
                'total_harga' => 12000000
            ]
        ];

        DB::table('materials')->insert($data);
    }
}
