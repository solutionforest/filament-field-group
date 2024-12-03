<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Text;

/**
 * @extends BaseTestCase<Text,\Filament\Forms\Components\TextInput>
 */
class TextTest extends BaseTestCase
{
    /** @test */
    protected static string $fieldTypeClass = Text::class;

    public function it_can_apply_config()
    {
        $maxLength = 255;
        $minLength = 10;
        $prefixLabel = 'Prefix';
        $suffixLabel = 'Suffix';
        $placeholder = 'Enter text';
        $defaultValue = 'Default Value';
        
        $field = $this->initializeFormComponentAndVerify(function (Text $text) use ($maxLength, $minLength, $prefixLabel, $suffixLabel, $placeholder, $defaultValue) {
            $text->maxLength = $maxLength;
            $text->minLength = $minLength;

            $text->prefixLabel = $prefixLabel;
            $text->suffixLabel = $suffixLabel;

            $text->placeholder = $placeholder;

            $text->defaultValue = $defaultValue;

            return $text;
        });

        $this->assertEquals($maxLength, $field->getMaxLength());
        $this->assertEquals($minLength, $field->getMinLength());

        $this->assertEquals($prefixLabel, $field->getPrefixLabel());
        $this->assertEquals($suffixLabel, $field->getSuffixLabel());

        $this->assertEquals($placeholder, $field->getPlaceholder());

        $this->assertEquals($defaultValue, $field->getDefaultState());
    }
}

