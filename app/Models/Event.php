<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Event extends Model
{
    protected $fillable = [
        'name',
        'starts_at',
        'ends_at',
    ];

    public function eventable(): MorphTo
    {
        return $this->morphTo(
            'eventable',
            'ownable_type',
            'ownable_id'
        );
    }
}
