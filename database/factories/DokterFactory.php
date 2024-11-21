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
        // Ambil user yang berperan sebagai 'dokter'
        $dokterUser = User::where('role', 'dokter')->inRandomOrder()->first();

        // Tentukan jenis dokter (umum atau spesialis)
        $jenisDokter = $this->faker->randomElement(['umum', 'spesialis']);

        // Jika jenis dokter adalah spesialis, tentukan spesialisasi
        $spesialisasi = null;
        if ($jenisDokter === 'spesialis') {
            $specialties = ['Kardiologi', 'Bedah Umum', 'Ortopedi', 'Pediatri', 'Neurologi'];
            $spesialisasi = $this->faker->randomElement($specialties);
        }

        return [
            'dokter_id' => $dokterUser->id,
            'jenis_dokter' => $jenisDokter,
            'spesialisasi' => $spesialisasi,
        ];
    }
}