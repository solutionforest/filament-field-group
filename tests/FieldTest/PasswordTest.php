<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Password;

/**
 * @extends BaseTestCase<Password,\Filament\Forms\Components\TextInput>
 */
class PasswordTest extends BaseTestCase
{
    protected static string $fieldTypeClass = Password::class;

    /** @test */
    public function it_can_apply_config()
    {
        $field = $this->initializeFormComponentAndVerify(fn (Password $password)  => $password);

        $this->assertEquals(true, $field->isPassword());
    }
}