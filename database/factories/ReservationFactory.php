<?php

namespace Database\Factories;

use App\Enums\Reservation\Status;
use App\Models\{Checkout, Event, Speciality, User};
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    public function definition(): array
    {
        $now = now();

        return [
            'comment'       => fake()->paragraphs(asText: true),
            'event_id'      => Event::inRandomOrder()->first()->id,
            'speciality_id' => Speciality::inRandomOrder()->first()->id,
            'user_id'       => User::inRandomOrder()->first()->id,
            'checkout_id'   => Checkout::inRandomOrder()->first()->id,
            'status'        => fake()->randomElements(Status::cases()),
            'created_at'    => $now,
            'updated_at'    => $now,
            'deleted_at'    => fake()->word(),
        ];
    }
}
