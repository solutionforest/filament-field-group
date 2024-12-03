<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\ColorPicker;

/**
 * @extends BaseTestCase<ColorPicker,\Filament\Forms\Components\ColorPicker>
 */
class ColorPickerTest extends BaseTestCase
{
    protected static string $fieldTypeClass = ColorPicker::class;

    /** @test */
    public function it_can_apply_config()
    {
        $defaultValue = '#000000';

        $field = $this->initializeFormComponentAndVerify(function (ColorPicker $colorPicker) use ($defaultValue) {
            $colorPicker->defaultValue = $defaultValue;

            return $colorPicker;
        });

        $this->assertEquals($defaultValue, $field->getDefaultState());
    }
}