<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use Filament\Forms\Components\Radio;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Radio as RadioConfig;

/**
 * @extends BaseTestCase<RadioConfig,Radio>
 */
class RadioTest extends BaseTestCase
{
    /** @test */
    protected static string $fieldTypeClass = RadioConfig::class;

    public function it_can_apply_config()
    {
        $options = ['option1', 'option2', 'option3'];

        $field = $this->initializeFormComponentAndVerify(function (RadioConfig $radio) use ($options) {
            $radio->options = $options;

            return $radio;
        });

        $this->assertEquals($options, $field->getOptions());
    }
}
