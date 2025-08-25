<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $surveys = [
            [
                'nama' => 'Survey Rumah Type 36',
                'hasil_survey' => 'Kondisi rumah cukup baik, perlu perbaikan kecil di bagian atap dan plafon. Listrik perlu penambahan stop kontak di beberapa ruangan.',
                'dokumentasi' => json_encode([
                    "surveys/VgC2D6BASMixmaLq80MxMBU4JApC5AK4GKmZd34A.jpg",
                    "surveys/wGNK1267Snlw3fRNF4ZmptUqjjDBreuevvdWqVvk.jpg",
                    "surveys/r6zSOHKWhFrwgpVpu5D9nCliQ4901pOrvkafUTLY.jpg"
                ])
            ],
            [
                'nama' => 'Survey Apartemen Tipe Studio',
                'hasil_survey' => 'Unit dalam kondisi sangat baik, hanya perlu pengecatan ulang dan perbaikan keran wastafel kamar mandi. Tidak ditemukan kerusakan struktural.',
                'dokumentasi' => json_encode([
                    "surveys/3R05Sz8GTNeWmdEapITXtzTUBeDGOmpKtP7mZmox.jpg",
                    "surveys/hE6AY1jaTtnegt5e3bCsMBlDJQ0cofWDsH88dDci.jpg",
                    "surveys/jIm6xoV2GKlAtGhG0tYu3VS8JMMVWdKgmeD65IDh.jpg",
                    "surveys/fmjosRDJ5ivMNOlnte8Nv6sj4dJWgQgBbOv3hbBz.jpg",
                    "surveys/susQCIOl5ZLx8to5amc4J2vbI6W4h7FK9uhdAX1O.jpg"
                ])
            ],
            [
                'nama' => 'Survey Rumah Type 45',
                'hasil_survey' => 'Kerusakan cukup parah di bagian dinding belakang yang retak struktural. Perlu perbaikan fondasi dan dinding. Instalasi air perlu diperbaiki karena terjadi kebocoran.',
                'dokumentasi' => null
            ],
        ];

        DB::table('surveys')->insert($surveys);
    }
}
