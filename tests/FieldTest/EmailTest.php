<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use Filament\Forms\Components\TextInput;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Email as EmailConfig;

/**
 * @extends BaseTestCase<EmailConfig,TextInput>
 */
class EmailTest extends BaseTestCase
{
    protected static string $fieldTypeClass = EmailConfig::class;

    /** @test */
    public function it_can_apply_config()
    {
        $placeholder = 'Enter email here';

        $field = $this->initializeFormComponentAndVerify(function (EmailConfig $email) use ($placeholder) {
            $email->placeholder = $placeholder;

            return $email;
        });

        $this->assertEquals($placeholder, $field->getPlaceholder());
    }
}
