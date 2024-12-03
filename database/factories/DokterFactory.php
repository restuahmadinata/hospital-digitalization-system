<?php

namespace Database\Factories;

use App\Models\Dokter;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DokterFactory extends Factory
{
    protected $model = Dokter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'dokter_id' => User::factory(),
            'jenis_dokter' => $this->faker->randomElement(['umum', 'spesialis']),
            'spesialisasi' => $this->faker->optional()->word,
        ];
    }
}