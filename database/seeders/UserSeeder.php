<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        (User::create([
            'name'              => 'Admin',
            'email'             => 'admin@admin.com',
            'email_verified_at'  => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]))->assignRole('Super Admin');

        if (app()->isLocal()) {
            User::factory(50)->create();
        }
    }
}
