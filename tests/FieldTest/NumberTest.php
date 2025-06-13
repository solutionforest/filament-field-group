<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use Filament\Forms\Components\TextInput;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Number as NumberInputConfig;

/**
 * @extends BaseTestCase<NumberInputConfig,TextInput>
 */
class NumberTest extends BaseTestCase
{
    protected static string $fieldTypeClass = NumberInputConfig::class;

    /** @test */
    public function it_can_apply_config()
    {
        $placeholder = 'Enter number here';
        $min = 1;
        $max = 10;

        $field = $this->initializeFormComponentAndVerify(function (NumberInputConfig $number) use ($placeholder, $min, $max) {
            $number->placeholder = $placeholder;
            $number->minValue = $min;
            $number->maxValue = $max;

            return $number;
        });

        $this->assertEquals($placeholder, $field->getPlaceholder());
        $this->assertEquals($min, $field->getMinValue());
        $this->assertEquals($max, $field->getMaxValue());
    }
}
