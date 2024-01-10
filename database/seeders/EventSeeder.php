<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $start = today();

        Teacher::first()->events()->save(Event::make([
            'title' => 'Cours de patin',
            'start' => $start,
            'end'   => Carbon::parse($start)->addHours(random_int(1, 4))
        ]));

        if (app()->isLocal()) {
            Teacher::each(static fn(Teacher $teacher) => $teacher->events()->saveMany(Event::factory(random_int(2, 10))->make()));
        }
    }
}