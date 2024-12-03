<?php

namespace SolutionForest\FilamentFieldGroup\Tests\Models;

use SolutionForest\FilamentFieldGroup\Tests\Support\TestModels\Field;
use SolutionForest\FilamentFieldGroup\Tests\Support\TestModels\FieldGroup;
use SolutionForest\FilamentFieldGroup\Tests\TestCase;

class FieldGroupTest extends TestCase
{
    /** @test */
    public function it_can_convert_to_filament_component()
    {
        // Arrange
        $fieldGroup = FieldGroup::factory()->create([
            'title' => 'Test Group',
        ]);

        $field = Field::factory()->create([
            'group_id' => $fieldGroup->id,
            'name' => 'test_field',
            'label' => 'Test Field',
            'instructions' => 'Test instructions',
            'mandatory' => true,
            'type' => 'text',
            'config' => [],
        ]);

        // Act
        $component = $fieldGroup->toFilamentComponent();

        // Assert
        $this->assertInstanceOf(\Filament\Forms\Components\Section::class, $component);
        $this->assertEquals('Test Group', $component->getHeading());
        $this->assertCount(1, $component->getChildComponents());
        $this->assertEquals('test_field', $component->getChildComponents()[0]->getName());
        $this->assertEquals('Test Field', $component->getChildComponents()[0]->getLabel());
        $this->assertEquals('Test instructions', $component->getChildComponents()[0]->getHelperText());
        $this->assertTrue($component->getChildComponents()[0]->isRequired());
    }

    /** @test */
    public function it_deletes_related_fields_when_deleted()
    {
        // Arrange
        $fieldGroup = FieldGroup::factory()->create();
        $field = Field::factory()->create([
            'group_id' => $fieldGroup->id,
        ]);

        // Act
        $fieldGroup->delete();

        // Assert
        $this->assertDatabaseMissing($field, [
            'id' => $field->id,
        ]);
    }
}
