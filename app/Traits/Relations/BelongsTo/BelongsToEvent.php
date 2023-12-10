<?php

namespace App\Traits\Relations\BelongsTo;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToEvent
{
    public function initializeBelongsToEvent(): void
    {
        if (!in_array('event_id', $this->fillable, true)) {
            $this->fillable[] = 'event_id';
        }
    }

    /**
     * @return BelongsTo<Event, Model>
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}