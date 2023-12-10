<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Teacher::each(static fn(Teacher $teacher) => $teacher->events()->saveMany(Event::factory(random_int(2, 10))->make()));
    }
}