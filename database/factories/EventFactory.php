<?php

namespace Database\Factories;

use App\Models\Event;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * @throws Exception
     */
    public function definition(): array
    {
        $start = fake()->dateTimeThisMonth();

        return [
            'title' => fake()->jobTitle,
            'start' => $start,
            'end'   => Carbon::parse($start)->addHours(random_int(1, 4))
        ];
    }
}
