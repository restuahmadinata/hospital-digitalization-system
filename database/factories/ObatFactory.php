<?php

namespace Database\Factories;

use App\Models\Obat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ObatFactory extends Factory
{
    protected $model = Obat::class;

    public function definition()
    {
        $tanggalKedaluwarsa = $this->faker->dateTimeBetween('now', '+2 years');
        $statusKedaluwarsa = Carbon::now()->gt($tanggalKedaluwarsa) ? 'kedaluwarsa' : 'belum kedaluwarsa';

        return [
            'nama_obat' => $this->faker->unique()->word,
            'deskripsi' => $this->faker->sentence,
            'tipe_obat' => $this->faker->randomElement(['keras', 'biasa']),
            'stok' => $this->faker->numberBetween(10, 200),
            'gambar_obat' => 'images/gambar_obat_placeholder.jpg',
            'kedaluwarsa' => $tanggalKedaluwarsa->format('Y-m-d'),
            'status_kedaluwarsa' => $statusKedaluwarsa,
        ];
    }
}