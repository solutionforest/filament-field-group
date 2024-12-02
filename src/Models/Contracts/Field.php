<?php

namespace SolutionForest\FilamentFieldGroup\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
interface Field extends Sortable
{
    public function group(): BelongsTo;
}
