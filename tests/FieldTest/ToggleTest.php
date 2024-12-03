<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Toggle;

/**
 * @extends BaseTestCase<Toggle,\Filament\Forms\Components\Toggle>
 */
class ToggleTest extends BaseTestCase
{
    /** @test */
    protected static string $fieldTypeClass = Toggle::class;

    public function it_can_apply_config()
    {
        $field = $this->initializeFormComponentAndVerify(function (Toggle $toggle) {
            return $toggle;
        });
    }
}
