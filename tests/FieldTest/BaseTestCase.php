<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use SolutionForest\FilamentFieldGroup\Tests\TestCase;

/**
 * @template TField \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig
 * @template TFieldComponent \Filament\Forms\Components\Component
 */
abstract class BaseTestCase extends TestCase
{
    /**
     * @var string The class name of the field type being tested.
     */
    protected static string $fieldTypeClass;

    /** @test */
    public function it_can_macroable()
    {
        $fieldType = $this->buildFieldType();

        $fieldType->macro('testMacro', function () {
            return 'test';
        });

        $this->assertEquals('test', $fieldType->testMacro());
    }

    /**
     * Builds a form component and performs assertions using the provided field type callback.
     *
     * @param  callable(TField)  $fieldTypeCallback  A callback function that defines the field type to be used in the form component.
     * @return TFieldComponent The form component.
     */
    protected function initializeFormComponentAndVerify($fieldTypeCallback)
    {
        $fieldType = $fieldTypeCallback($this->buildFieldType());

        [$component, $field] = $this->buildFormComponentForFieldType($fieldType);

        $targetFormComponent = $fieldType->getFormComponents()[0]['component'];

        $this->assertInstanceOf($targetFormComponent, $field);

        return $field;
    }

    /**
     * @return TField
     */
    private function buildFieldType()
    {
        return new static::$fieldTypeClass;
    }
}
