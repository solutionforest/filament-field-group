<?php

namespace SolutionForest\FilamentFieldGroup\Tests\Models;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Schema;
use Illuminate\Support\Arr;
use SolutionForest\FilamentFieldGroup\Tests\Fixtures\Livewire\Livewire;
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
        $component = $fieldGroup
            ->toFilamentComponent()
            ->container(Schema::make(Livewire::make()));

        // Assert
        $this->assertInstanceOf(Section::class, $component);
        $this->assertEquals('Test Group', $component->getHeading());
        $this->assertCount(1, $component->getChildComponents());
        // /**
        //  * @var TextInput
        //  */
        $textInputComponent = Arr::first($component->getChildComponents());
        $this->assertTrue($textInputComponent != null);
        $this->assertEquals('test_field', $textInputComponent->getName());
        $this->assertEquals('Test Field', $textInputComponent->getLabel());
        // /**
        //  * @var Text
        //  */
        $helperTextComponent = $textInputComponent ? Arr::first($textInputComponent->getChildComponents('below_content')) : null;
        $this->assertTrue($helperTextComponent != null);
        $this->assertEquals('Test instructions', $helperTextComponent->getContent());
        $this->assertTrue($textInputComponent->isRequired());
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
