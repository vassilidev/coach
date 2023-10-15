<?php

namespace App\Traits\Relations\BelongsTo;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToCategory
{
    public function initializeBelongsToCategory(): void
    {
        if (!in_array('category_id', $this->fillable, true)) {
            $this->fillable[] = 'category_id';
        }
    }

    /**
     * @return BelongsTo<Category, Model>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}