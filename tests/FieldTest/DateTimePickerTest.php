<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use Filament\Forms\Components\DateTimePicker;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\DateTimePicker as DateTimePickerConfig;

/**
 * @extends BaseTestCase<DateTimePickerConfig,DateTimePicker>
 */
class DateTimePickerTest extends BaseTestCase
{
    protected static string $fieldTypeClass = DateTimePickerConfig::class;

    /** @test */
    public function it_can_apply_config()
    {
        $defaultValue = '2021-01-01 00:00:00';

        $field = $this->initializeFormComponentAndVerify(function (DateTimePickerConfig $dateTimePicker) use ($defaultValue) {
            $dateTimePicker->defaultValue = $defaultValue;

            return $dateTimePicker;
        });

        $this->assertEquals($defaultValue, $field->getDefaultState());
    }
}
