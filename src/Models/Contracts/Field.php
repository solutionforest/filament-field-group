<?php

namespace SolutionForest\FilamentFieldGroup\Models\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SolutionForest\FilamentFieldGroup\Models\Contracts\FieldGroup;
use Spatie\EloquentSortable\Sortable;

/**
 * @property string $name
 * @property string $label
 * @property string $type
 * @property int $group_id
 * @property int $sort
 * @property ?string $instructions
 * @property bool $mandatory
 * @property ?string $state_path
 * @property ?array $config
 * @property ?\DateTimeInterface $created_at
 * @property ?\DateTimeInterface $updated_at
 * 
 * @property-read null | Model&FieldGroup $group
 */
interface Field extends Sortable
{
    public function group(): BelongsTo;
}
