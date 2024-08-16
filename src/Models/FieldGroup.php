<?php

namespace SolutionForest\FilamentFieldGroup\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use SolutionForest\FilamentFieldGroup\Facades\FilamentFieldGroup;
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

    /**
     * @return \Filament\Forms\Components\Component
     */
    public function toFilamentComponent()
    {
        $schema = [];

        foreach ($this->fields as $field) {

            $fiFormConfig = FilamentFieldGroup::getFieldTypeConfig($field->type, $field->config);

            if (! $fiFormConfig) {
                continue;
            }

            $fiFormComponentFQCN = Arr::first(Arr::pluck($fiFormConfig->getFormComponents(), 'component'));
            if (! $fiFormComponentFQCN) {
                throw new \Exception("The field type config class {$fiFormConfig} does not have a FormComponent attribute.");
            }

            $fiFormComponent = $fiFormComponentFQCN::make($field->name);

            // @todo - some components may not have these methods
            $fiFormComponent->label($field->label);
            $fiFormComponent->helperText($field->instructions);
            $fiFormComponent->required($field->mandatory);

            $fiFormConfig->applyConfig($fiFormComponent);

            $schema[] = $fiFormComponent;
        }

        return \Filament\Forms\Components\Section::make($this->title)
            ->schema($schema);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function (FieldGroup $group) {
            $group->fields->each->delete();
        });
    }
}
