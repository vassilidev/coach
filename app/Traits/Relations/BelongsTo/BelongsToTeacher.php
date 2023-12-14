<?php

namespace App\Traits\Relations\BelongsTo;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTeacher
{

    public function initializeBelongsToTeacher(): void
    {
        if (!in_array('teacher_id', $this->fillable, true)) {
            $this->fillable[] = 'teacher_id';
        }
    }

    /**
     * @return BelongsTo<Teacher, Model>
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
