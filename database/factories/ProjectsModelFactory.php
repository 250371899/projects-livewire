<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * 
 */
class ProjectsModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    

      public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('+1 day', '+1 month');

        return [
            'title'       => $this->faker->realTextBetween(10, 30),
            'description' => $this->faker->text(50),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'end_date'   => $this->faker->dateTimeBetween('+1 month', '+2 months')->format('Y-m-d'),
            'phase'       => $this->faker->randomElement(['design', 'development', 'testing', 'deployment', 'complete']),
            'uid'         => 1,
            'created_at'  => now(),
        ];
    }
}
