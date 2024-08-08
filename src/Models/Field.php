<?php

namespace SolutionForest\FilamentFieldGroup\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Field extends Model implements Sortable
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

        $this->setTable(config('filament-field-group.table_names.fields'));
    }

    public function group()
    {
        return $this->belongsTo(FieldGroup::class, 'group_id');
    }

    public function buildSortQuery(): Builder
    {
        return static::query()->where('group_id', $this->group_id);
    }
}
