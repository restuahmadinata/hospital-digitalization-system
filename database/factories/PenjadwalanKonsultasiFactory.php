<?php

namespace Database\Factories;

use App\Models\PenjadwalanKonsultasi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class PenjadwalanKonsultasiFactory extends Factory
{
    protected $model = PenjadwalanKonsultasi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $pasien = User::where('role', 'pasien')->inRandomOrder()->first();
        $dokter = User::where('role', 'dokter')->inRandomOrder()->first();

        return [
            'id_pasien' => $pasien->id,
            'id_dokter' => $dokter->id,
            'tanggal_konsultasi' => Carbon::now()->addDays(3),
        ];
    }
}