<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface HasEvents
{
    public function events(): MorphToMany;
}