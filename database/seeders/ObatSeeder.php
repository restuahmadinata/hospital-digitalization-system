<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Obat;

class ObatSeeder extends Seeder
{
    public function run()
    {
        // Create 10 realistic medicine records
        Obat::factory()->count(10)->create();
    }
}
