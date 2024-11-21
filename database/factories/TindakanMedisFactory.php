<?php

namespace Database\Factories;

use App\Models\TindakanMedis;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class TindakanMedisFactory extends Factory
{
    protected $model = TindakanMedis::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Ambil Dokter dan Pasien secara acak dari database
        $dokterIds = User::where('role', 'dokter')->pluck('id')->toArray();
        $pasienIds = User::where('role', 'pasien')->pluck('id')->toArray();

        return [
            'pasien_id' => $this->faker->randomElement($pasienIds),
            'dokter_id' => $this->faker->randomElement($dokterIds),
            'deskripsi' => 'Pemeriksaan kesehatan rutin',
            'tanggal' => Carbon::today()->subDays(rand(1, 30)),
            'notifikasi' => rand(0, 3),
        ];
    }
}