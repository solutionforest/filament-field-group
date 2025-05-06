<?php

namespace SolutionForest\FilamentFieldGroup\Models\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Spatie\EloquentSortable\Sortable;

/**
 * @property string $title
 * @property string $name
 * @property bool $active
 * @property int $sort
 * @property ?\DateTimeInterface $created_at
 * @property ?\DateTimeInterface $updated_at
 * @property-read Collection<Model & Field> $fields
 */
interface FieldGroup extends Sortable
{
    public function fields(): HasMany;

    /**
     * @return \Filament\Forms\Components\Component
     */
    public function toFilamentComponent();
}
