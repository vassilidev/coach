<?php

namespace App\Traits\Relations\BelongsTo;

use App\Models\Speciality;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToSpeciality
{
    public function initializeBelongsToSpeciality(): void
    {
        if (!in_array('speciality_id', $this->fillable, true)) {
            $this->fillable[] = 'speciality_id';
        }
    }

    /**
     * @return BelongsTo<Speciality, Model>
     */
    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class);
    }
}