<?php

namespace SolutionForest\FilamentFieldGroup\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FieldFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->slug,
            'label' => $this->faker->numerify('Field ###'),
            'type' => 'text',
            'group_id' => 1,
            'sort' => $this->faker->randomNumber(),
            'instructions' => $this->faker->sentence,
            'mandatory' => $this->faker->boolean,
        ];
    }
}
