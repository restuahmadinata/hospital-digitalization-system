<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PenjadwalanKonsultasi;

class PenjadwalanKonsultasiSeeder extends Seeder
{
    public function run()
    {
        // Create 10 appointment records (penjadwalan konsultasi)
        PenjadwalanKonsultasi::factory()->count(10)->create();
    }
}
