<?php

namespace App\Models;

use App\Enums\Reservation\Status;
use App\Traits\Relations\BelongsTo\BelongsToCheckout;
use App\Traits\Relations\BelongsTo\BelongsToEvent;
use App\Traits\Relations\BelongsTo\BelongsToSpeciality;
use App\Traits\Relations\BelongsTo\BelongsToUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory,
        BelongsToUser,
        BelongsToEvent,
        BelongsToCheckout,
        BelongsToSpeciality;

    protected $fillable = [
        'status',
        'comment',
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    public function scopeStatus(Builder $query, Status $status): Builder
    {
        return $query->whereStatus($status);
    }

    public function scopeFinished(Builder $query): Builder
    {
        return $query->status(Status::FINISHED);
    }

    public function scopeNew(Builder $query): Builder
    {
        return $query->status(Status::NEW);
    }

    public function scopeCanceled(Builder $query): Builder
    {
        return $query->status(Status::CANCELED);
    }
}
