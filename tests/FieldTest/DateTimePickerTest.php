<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\DateTimePicker;

/**
 * @extends BaseTestCase<DateTimePicker,\Filament\Forms\Components\DateTimePicker>
 */
class DateTimePickerTest extends BaseTestCase
{
    protected static string $fieldTypeClass = DateTimePicker::class;

    /** @test */
    public function it_can_apply_config()
    {
        $defaultValue = '2021-01-01 00:00:00';

        $field = $this->initializeFormComponentAndVerify(function (DateTimePicker $dateTimePicker) use ($defaultValue) {
            $dateTimePicker->defaultValue = $defaultValue;

            return $dateTimePicker;
        });

        $this->assertEquals($defaultValue, $field->getDefaultState());
    }
}
