<?php

namespace SolutionForest\FilamentFieldGroup\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\Sortable;

interface Field extends Sortable 
{
    public function group(): BelongsTo;
}
