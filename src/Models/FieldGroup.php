<?php

namespace SolutionForest\FilamentFieldGroup\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SolutionForest\FilamentFieldGroup\Supports\FieldGroupConfig;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class FieldGroup extends Model implements Sortable
{
    use SortableTrait;

    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
    ];

    public $sortable = [
        'order_column_name' => 'sort',
        'sort_when_creating' => true,
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(FieldGroupConfig::getFieldGroupTableName());
    }

    public function fields(): HasMany
    {
        return $this->hasMany(FieldGroupConfig::getFieldModelClass(), 'group_id')->orderBy('sort');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function (FieldGroup $group) {
            $group->fields->each->delete();
        });
    }
}
