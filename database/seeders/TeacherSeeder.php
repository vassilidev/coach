<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::create([
            'user_id'     => User::first()->id,
            'description' => 'Super coach',
        ]);

        if (app()->isLocal()) {
            Teacher::factory(10)->create();
        }
    }
}
