<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use Filament\Forms\Components\TextInput;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Url as UrlInputConfig;

/**
 * @extends BaseTestCase<UrlInputConfig,TextInput>
 */
class UrlTest extends BaseTestCase
{
    protected static string $fieldTypeClass = UrlInputConfig::class;

    /** @test */
    public function it_can_apply_config()
    {
        $placeholder = 'Enter URL here';
        $defaultValue = 'https://example.com';

        $field = $this->initializeFormComponentAndVerify(function (UrlInputConfig $url) use ($placeholder, $defaultValue) {
            $url->placeholder = $placeholder;
            $url->defaultValue = $defaultValue;

            return $url;
        });

        $this->assertEquals($placeholder, $field->getPlaceholder());
        $this->assertEquals($defaultValue, $field->getDefaultState());
    }
}
