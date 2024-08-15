<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes;

use Attribute;
/**
 * @property string $drive The drive of the database.
 * @property string $type The type of the field in database.
 * @property int|null $length The length of the field in database.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class DbType
{
    public function __construct(
        public string $drive,
        public string $type,
        public ?int $length = null,
    ) {}
}
