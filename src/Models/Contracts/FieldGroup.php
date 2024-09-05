<?php

namespace SolutionForest\FilamentFieldGroup\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\Sortable;

interface FieldGroup extends Sortable
{
    public function fields(): HasMany;

    /**
     * @return \Filament\Forms\Components\Component
     */
    public function toFilamentComponent();
}
