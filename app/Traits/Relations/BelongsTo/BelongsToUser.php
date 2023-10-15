<?php

namespace App\Traits\Relations\BelongsTo;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToUser
{
    public function initializeBelongsToUser(): void
    {
        if (!in_array('user_id', $this->fillable, true)) {
            $this->fillable[] = 'user_id';
        }
    }

    /**
     * @return BelongsTo<User, Model>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}