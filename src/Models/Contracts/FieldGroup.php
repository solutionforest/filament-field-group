<?php

namespace SolutionForest\FilamentFieldGroup\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\Sortable;

/**
 * @property string $title
 * @property string $name
 * @property bool $active
 * @property int $sort
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
interface FieldGroup extends Sortable
{
    public function fields(): HasMany;

    /**
     * @return \Filament\Forms\Components\Component
     */
    public function toFilamentComponent();
}
