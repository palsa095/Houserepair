<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create([
            'name' => 'Pablo Serban',
            'phone' => '082847290344',
            'address' => 'Jalan Kaliurang KM. 13, Sukoharjo, Ngaglik, Sleman, Yogyakarta',
            'category' => 'Sedang',
            'project' => 'Renovasi Keseluruhan Rumah Dalam',
            'note' => 'Atap bocor, ada delapan titik kebocoran. Plafon jebol lumayan lebar.',
            'status' => 'Sudah selesai'
        ]);
    }
}
