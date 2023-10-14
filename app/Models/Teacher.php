<?php

namespace App\Models;

use App\Traits\Relations\BelongsTo\BelongsToUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory,
        HasUlids,
        BelongsToUser,
        SoftDeletes;

    protected $fillable = [
        'description',
    ];
}
