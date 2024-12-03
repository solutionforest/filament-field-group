<?php

namespace SolutionForest\FilamentFieldGroup\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FieldGroupFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->numerify('Field Group ###'),
            'name' => $this->faker->slug,
            'active' => true,
            'sort' => $this->faker->randomNumber(),
        ];
    }
}
