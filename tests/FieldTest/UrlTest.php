<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Url;

/**
 * @extends BaseTestCase<Url,\Filament\Forms\Components\TextInput>
 */
class UrlTest extends BaseTestCase
{
    protected static string $fieldTypeClass = Url::class;

    /** @test */
    public function it_can_apply_config()
    {
        $placeholder = 'Enter URL here';
        $defaultValue = 'https://example.com';

        $field = $this->initializeFormComponentAndVerify(function (Url $url) use ($placeholder, $defaultValue) {
            $url->placeholder = $placeholder;
            $url->defaultValue = $defaultValue;

            return $url;
        });

        $this->assertEquals($placeholder, $field->getPlaceholder());
        $this->assertEquals($defaultValue, $field->getDefaultState());
    }
}
