<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use Filament\Forms\Components\TextInput;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Password as PasswordInputConfig;

/**
 * @extends BaseTestCase<PasswordInputConfig,TextInput>
 */
class PasswordTest extends BaseTestCase
{
    protected static string $fieldTypeClass = PasswordInputConfig::class;

    /** @test */
    public function it_can_apply_config()
    {
        $field = $this->initializeFormComponentAndVerify(fn (PasswordInputConfig $password) => $password);

        $this->assertEquals(true, $field->isPassword());
    }
}
