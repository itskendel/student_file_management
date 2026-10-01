<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => fake()->unique()->numerify('20##-####'),
            'lrn' => fake()->unique()->numerify('#############'),

            'first_name' => fake()->firstName(),
            'middle_name' => fake()->optional(0.7)->firstName(),
            'last_name' => fake()->lastName(),
            'suffix' => fake()->optional(0.1)->randomElement(['Jr.', 'Sr.', 'II', 'III']),

            'birth_date' => fake()->dateTimeBetween('-19 years', '-16 years')->format('Y-m-d'),
            'sex' => fake()->randomElement(['Male', 'Female']),

            'email' => fake()->boolean(80) ? fake()->unique()->safeEmail() : null,
            'phone_number' => fake()->optional(0.8)->numerify('+63 9## ### ####'),
            'address' => fake()->optional(0.8)->address(),
        ];
    }

    /**
     * Indicate that the student has no optional profile details yet.
     */
    public function minimal(): static
    {
        return $this->state(fn (array $attributes) => [
            'student_id' => null,
            'lrn' => null,
            'middle_name' => null,
            'suffix' => null,
            'email' => null,
            'phone_number' => null,
            'address' => null,
        ]);
    }

    /**
     * Indicate that the student has completed the basic identity fields.
     */
    public function identified(): static
    {
        return $this->state(fn (array $attributes) => [
            'student_id' => fake()->unique()->numerify('20##-####'),
            'lrn' => fake()->unique()->numerify('#############'),
        ]);
    }
}
