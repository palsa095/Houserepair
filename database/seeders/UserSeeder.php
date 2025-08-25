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
        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);

        // Customer
        User::create([
            'name' => 'John Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        User::create([
            'name' => 'Jane Customer',
            'email' => 'jane.customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Admin Surveyor
        User::create([
            'name' => 'Surveyor Admin',
            'email' => 'surveyor@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin_surveyor',
        ]);

        User::create([
            'name' => 'Budi Surveyor',
            'email' => 'budi.surveyor@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin_surveyor',
        ]);

        // Admin Supplier
        User::create([
            'name' => 'Supplier Admin',
            'email' => 'supplier@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin_supplier',
        ]);

        User::create([
            'name' => 'Sari Supplier',
            'email' => 'sari.supplier@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin_supplier',
        ]);

        // Admin Tukang
        User::create([
            'name' => 'Tukang Admin',
            'email' => 'tukang@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin_tukang',
        ]);

        User::create([
            'name' => 'Ahmad Tukang',
            'email' => 'ahmad.tukang@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin_tukang',
        ]);

        // Additional Customers for testing
        User::create([
            'name' => 'Dewi Customer',
            'email' => 'dewi.customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        User::create([
            'name' => 'Rudi Customer',
            'email' => 'rudi.customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Additional Surveyors
        User::create([
            'name' => 'Citra Surveyor',
            'email' => 'citra.surveyor@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin_surveyor',
        ]);

        // Additional Suppliers
        User::create([
            'name' => 'Rina Supplier',
            'email' => 'rina.supplier@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin_supplier',
        ]);

        // Additional Tukang
        User::create([
            'name' => 'Bambang Tukang',
            'email' => 'bambang.tukang@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin_tukang',
        ]);

        $this->command->info('User accounts created successfully!');
        $this->command->info('Super Admin: admin@example.com / password');
        $this->command->info('Customer: customer@example.com / password');
        $this->command->info('Surveyor: surveyor@example.com / password');
        $this->command->info('Supplier: supplier@example.com / password');
        $this->command->info('Tukang: tukang@example.com / password');
    }
}
