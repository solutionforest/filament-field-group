<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\TextArea;

/**
 * @extends BaseTestCase<TextArea,\Filament\Forms\Components\TextArea>
 */
class TextAreaTest extends BaseTestCase
{
    protected static string $fieldTypeClass = TextArea::class;

    /** @test */
    public function it_can_apply_config()
    {
        $rows = 5;
        $placeholder = 'Enter text here';
        $defaultValue = 'Default text';

        $field = $this->initializeFormComponentAndVerify(function (TextArea $textArea) use ($rows, $placeholder, $defaultValue) {
            $textArea->rows = $rows;
            $textArea->placeholder = $placeholder;
            $textArea->defaultValue = $defaultValue;

            return $textArea;
        });

        $this->assertEquals($rows, $field->getRows());
        $this->assertEquals($placeholder, $field->getPlaceholder());
        $this->assertEquals($defaultValue, $field->getDefaultState());
    }
}