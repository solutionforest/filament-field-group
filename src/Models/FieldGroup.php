<?php

namespace Solutionforest\FilamentAdvancedFields\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FieldGroup extends Model
{
    protected $fillable = [
        'name',
        'location',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }
}
