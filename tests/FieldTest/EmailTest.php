<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Email;

/**
 * @extends BaseTestCase<Email,\Filament\Forms\Components\TextInput>
 */
class EmailTest extends BaseTestCase
{
    protected static string $fieldTypeClass = Email::class;

    /** @test */
    public function it_can_apply_config()
    {
        $placeholder = 'Enter email here';
        
        $field = $this->initializeFormComponentAndVerify(function (Email $email) use ($placeholder) {
            $email->placeholder = $placeholder;
            
            return $email;
        });

        $this->assertEquals($placeholder, $field->getPlaceholder());
    }
}