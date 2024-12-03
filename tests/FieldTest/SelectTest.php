<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Select;

/**
 * @extends BaseTestCase<Select,\Filament\Forms\Components\Select>
 */
class SelectTest extends BaseTestCase
{
    /** @test */
    protected static string $fieldTypeClass = Select::class;

    public function it_can_apply_config()
    {
        $options = ['option1', 'option2', 'option3'];

        $field = $this->initializeFormComponentAndVerify(function (Select $select) use ($options) {
            $select->options = $options;

            return $select;
        });

        $this->assertEquals($options, $field->getOptions());
    }
}
