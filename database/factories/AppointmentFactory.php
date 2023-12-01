<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => fake()->numberBetween(2, 4),
            'doctor_id' => fake()->numberBetween(5, 6),
            'patient_complaints' => fake()->text(),
            'status' => fake()->randomElement(['menunggu', 'sedang konsultasi', 'selesai', 'ditolak']),
            'medical_record_id' => fake()->randomElement([null, 1, 2, 3, 4, 5]),
        ];
    }
}
