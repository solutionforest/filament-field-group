<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use Filament\Forms\Components\ColorPicker;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\ColorPicker as ColorPickerConfig;

/**
 * @extends BaseTestCase<ColorPickerConfig,ColorPicker>
 */
class ColorPickerTest extends BaseTestCase
{
    protected static string $fieldTypeClass = ColorPickerConfig::class;

    /** @test */
    public function it_can_apply_config()
    {
        $defaultValue = '#000000';

        $field = $this->initializeFormComponentAndVerify(function (ColorPickerConfig $colorPicker) use ($defaultValue) {
            $colorPicker->defaultValue = $defaultValue;

            return $colorPicker;
        });

        $this->assertEquals($defaultValue, $field->getDefaultState());
    }
}
