<?php

namespace Database\Factories;

use App\Models\JadwalTugas;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JadwalTugasFactory extends Factory
{
    protected $model = JadwalTugas::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dokter = User::where('role', 'dokter')->inRandomOrder()->first();

        return [
            'dokter_id' => $dokter->id,
            'hari_tugas' => $this->faker->randomElement(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']),
        ];
    }
}