<?php

namespace Database\Seeders;

use App\Models\Speciality;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class SpecialityTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws \Exception
     */
    public function run(): void
    {
        foreach (Teacher::all() as $teacher) {
            $teacher
                ->specialities()
                ->attach(
                    Speciality::query()
                        ->inRandomOrder()
                        ->take(random_int(1, 5))
                        ->pluck('id')
                );
        }
    }
}
