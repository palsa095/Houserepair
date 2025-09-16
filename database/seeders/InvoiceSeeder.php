<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\InvoiceItem;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $invoice = Invoice::create([
            'number' => 'HR-00',
            'date' => '2023-08-01',
            'customer_name' => 'Russel Imanuel',
            'customer_address' => 'Jalan Kaliurang KM. 13,5',
            'customer_phone' => '+62 81267908769',
            'package' => 'Paket Sedang',
            'project' => 'Renovasi Kamar Mandi',
            'currency' => 'Rp',
            'total' => 800000,
        ]);

        $items = [
            ['title' => 'Survey', 'subtotal' => 200000],
            ['title' => 'Pengerjaan Lapangan', 'subtotal' => 200000],
            ['title' => 'Bahan untuk Pengerjaan', 'subtotal' => 400000],
        ];

        foreach ($items as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'title' => $item['title'],
                'subtotal' => $item['subtotal'],
            ]);
        }
    }
}
