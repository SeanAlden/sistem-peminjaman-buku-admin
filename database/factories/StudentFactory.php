<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'major' => $this->faker->randomElement([
                'Computer Science',
                'Information Systems',
                'Mathematics',
                'Physics',
                'Engineering'
            ]),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('08##########'), // 12 digit
            'description' => $this->faker->sentence(8),
        ];
    }
}
