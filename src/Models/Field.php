<?php

namespace SolutionForest\FilamentFieldGroup\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SolutionForest\FilamentFieldGroup\Models\Contracts\Field as FieldContact;
use SolutionForest\FilamentFieldGroup\Supports\FieldGroupConfig;
use Spatie\EloquentSortable\SortableTrait;

class Field extends Model implements FieldContact
{
    use SortableTrait;

    protected $guarded = [];

    public $sortable = [
        'order_column_name' => 'sort',
        'sort_when_creating' => true,
    ];

    protected $casts = [
        'mandatory' => 'boolean',
        'config' => 'json',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(FieldGroupConfig::getFieldTableName());
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(FieldGroupConfig::getFieldGroupModelClass(), 'group_id');
    }

    public function buildSortQuery(): Builder
    {
        return static::query()->where('group_id', $this->group_id);
    }
}
