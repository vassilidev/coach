<?php

namespace App\Models;

use App\Traits\Relations\BelongsTo\BelongsToTeacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory,
        SoftDeletes,
        BelongsToTeacher;

    protected $fillable = [
        'title',
        'start',
        'end',
    ];
}
