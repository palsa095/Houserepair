<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password'), 'role' => 'super_admin']
        );

        User::updateOrCreate(
            ['email' => 'customer@example.com'],
            ['name' => 'John Customer', 'password' => Hash::make('password'), 'role' => 'customer']
        );

        User::updateOrCreate(
            ['email' => 'jane.customer@example.com'],
            ['name' => 'Jane Customer', 'password' => Hash::make('password'), 'role' => 'customer']
        );

        User::updateOrCreate(
            ['email' => 'surveyor@example.com'],
            ['name' => 'Surveyor Admin', 'password' => Hash::make('password'), 'role' => 'admin_surveyor']
        );

        User::updateOrCreate(
            ['email' => 'budi.surveyor@example.com'],
            ['name' => 'Budi Surveyor', 'password' => Hash::make('password'), 'role' => 'admin_surveyor']
        );

        User::updateOrCreate(
            ['email' => 'supplier@example.com'],
            ['name' => 'Supplier Admin', 'password' => Hash::make('password'), 'role' => 'admin_supplier']
        );

        User::updateOrCreate(
            ['email' => 'sari.supplier@example.com'],
            ['name' => 'Sari Supplier', 'password' => Hash::make('password'), 'role' => 'admin_supplier']
        );

        User::updateOrCreate(
            ['email' => 'tukang@example.com'],
            ['name' => 'Tukang Admin', 'password' => Hash::make('password'), 'role' => 'admin_tukang']
        );

        User::updateOrCreate(
            ['email' => 'ahmad.tukang@example.com'],
            ['name' => 'Ahmad Tukang', 'password' => Hash::make('password'), 'role' => 'admin_tukang']
        );

        User::updateOrCreate(
            ['email' => 'dewi.customer@example.com'],
            ['name' => 'Dewi Customer', 'password' => Hash::make('password'), 'role' => 'customer']
        );

        User::updateOrCreate(
            ['email' => 'rudi.customer@example.com'],
            ['name' => 'Rudi Customer', 'password' => Hash::make('password'), 'role' => 'customer']
        );

        User::updateOrCreate(
            ['email' => 'citra.surveyor@example.com'],
            ['name' => 'Citra Surveyor', 'password' => Hash::make('password'), 'role' => 'admin_surveyor']
        );

        User::updateOrCreate(
            ['email' => 'rina.supplier@example.com'],
            ['name' => 'Rina Supplier', 'password' => Hash::make('password'), 'role' => 'admin_supplier']
        );

        User::updateOrCreate(
            ['email' => 'bambang.tukang@example.com'],
            ['name' => 'Bambang Tukang', 'password' => Hash::make('password'), 'role' => 'admin_tukang']
        );

        $this->command->info('User accounts created successfully!');
        $this->command->info('Super Admin: admin@example.com / password');
        $this->command->info('Customer: customer@example.com / password');
        $this->command->info('Surveyor: surveyor@example.com / password');
        $this->command->info('Supplier: supplier@example.com / password');
        $this->command->info('Tukang: tukang@example.com / password');
    }
}
