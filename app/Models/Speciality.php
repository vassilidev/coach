<?php

namespace App\Models;

use App\Traits\Relations\BelongsTo\BelongsToCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Speciality extends Model
{
    use HasFactory,
        SoftDeletes,
        BelongsToCategory;

    protected $fillable = [
        'name',
        'slug',
    ];
}
