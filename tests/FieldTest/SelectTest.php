<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use Filament\Forms\Components\Select;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Select as SelectConfig;

/**
 * @extends BaseTestCase<SelectConfig,Select>
 */
class SelectTest extends BaseTestCase
{
    /** @test */
    protected static string $fieldTypeClass = SelectConfig::class;

    public function it_can_apply_config()
    {
        $options = ['option1', 'option2', 'option3'];

        $field = $this->initializeFormComponentAndVerify(function (SelectConfig $select) use ($options) {
            $select->options = $options;

            return $select;
        });

        $this->assertEquals($options, $field->getOptions());
    }
}
