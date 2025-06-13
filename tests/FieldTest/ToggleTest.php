<?php

namespace SolutionForest\FilamentFieldGroup\Tests\FieldTest;

use Filament\Forms\Components\Toggle;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Toggle as ToggleConfig;

/**
 * @extends BaseTestCase<ToggleConfig,Toggle>
 */
class ToggleTest extends BaseTestCase
{
    /** @test */
    protected static string $fieldTypeClass = ToggleConfig::class;

    public function it_can_apply_config()
    {
        $field = $this->initializeFormComponentAndVerify(function (ToggleConfig $toggle) {
            return $toggle;
        });
    }
}
