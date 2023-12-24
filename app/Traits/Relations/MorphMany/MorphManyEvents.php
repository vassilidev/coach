<?php

namespace App\Traits\Relations\MorphMany;

use App\Models\Event;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait MorphManyEvents
{
    public function events(): MorphToMany
    {
        return $this->morphToMany(Event::class, 'eventable');
    }
}
