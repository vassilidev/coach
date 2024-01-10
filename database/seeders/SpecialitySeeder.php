<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Speciality;
use Illuminate\Database\Seeder;

class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Speciality::create([
            'name'        => 'Vitesse',
            'slug'        => 'vitesse',
            'category_id' => Category::first()->id,
        ]);

        if (app()->isLocal()) {
            Speciality::factory(15)->create();
        }
    }
}
