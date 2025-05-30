<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'kitchen']);
        Role::firstOrCreate(['name' => 'cashier']);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'is_admin' => true,
        ]);
        $admin->assignRole('admin');

        $kitchen = User::create([
            'name' => 'Kitchen Staff',
            'email' => 'kitchen@gmail.com',
            'password' => bcrypt('kitchen'),
            'is_admin' => false,
        ]);
        $kitchen->assignRole('kitchen');

        $cashier = User::create([
            'name' => 'Cashier',
            'email' => 'cashier@gmail.com',
            'password' => bcrypt('cashier'),
            'is_admin' => false,
        ]);
        $cashier->assignRole('cashier');
    }
}
