<?php

namespace Database\Factories;

use App\Models\RekamMedis;
use App\Models\User;
use App\Models\Obat;
use Illuminate\Database\Eloquent\Factories\Factory;

class RekamMedisFactory extends Factory
{
    protected $model = RekamMedis::class;

    public function definition()
    {
        return [
            'pasien_id' => User::where('role', 'pasien')->inRandomOrder()->first()->id,
            'dokter_id' => User::where('role', 'dokter')->inRandomOrder()->first()->id,
            'tindakan' => $this->faker->sentence(),
            'tanggal_berobat' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'penyakit' => $this->faker->sentence(),
        ];
    }

    public function withObat($count = 3)
    {
        return $this->afterCreating(function (RekamMedis $rekamMedis) use ($count) {
            $obatIds = Obat::inRandomOrder()->limit($count)->pluck('id');
            foreach ($obatIds as $obatId) {
                $rekamMedis->obats()->attach($obatId, ['jumlah' => rand(1, 5)]); // Tambahkan kolom jumlah
            }
        });
    }
}