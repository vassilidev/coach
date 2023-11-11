<?php

namespace App\Traits\Relations\MorphMany;

use App\Models\Event;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait MorphManyEvents
{
    /**
     * @return MorphMany
     */
    public function events(): MorphMany
    {
        return $this->morphMany(Event::class, 'ownable');
    }
}
