<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Radio;

/**
 * @extends BaseTestCase<Radio,\Filament\Forms\Components\Radio>
 */
class RadioTest extends BaseTestCase
{
    /** @test */
    protected static string $fieldTypeClass = Radio::class;

    public function it_can_apply_config()
    {
        $options = ['option1', 'option2', 'option3'];

        $field = $this->initializeFormComponentAndVerify(function (Radio $radio) use ($options) {
            $radio->options = $options;

            return $radio;
        });

        $this->assertEquals($options, $field->getOptions());
    }
}
