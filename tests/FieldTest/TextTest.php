<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use Filament\Forms\Components\TextInput;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Text as TextInputConfig;

/**
 * @extends BaseTestCase<TextInputConfig,TextInput>
 */
class TextTest extends BaseTestCase
{
    /** @test */
    protected static string $fieldTypeClass = TextInputConfig::class;

    public function it_can_apply_config()
    {
        $maxLength = 255;
        $minLength = 10;
        $prefixLabel = 'Prefix';
        $suffixLabel = 'Suffix';
        $placeholder = 'Enter text';
        $defaultValue = 'Default Value';

        $field = $this->initializeFormComponentAndVerify(function (TextInputConfig $text) use ($maxLength, $minLength, $prefixLabel, $suffixLabel, $placeholder, $defaultValue) {
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
