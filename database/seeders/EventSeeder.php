<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::factory(50)->create();

        Event::each(static fn(Event $event) => Teacher::inRandomOrder()->first()->events()->attach($event));
    }
}