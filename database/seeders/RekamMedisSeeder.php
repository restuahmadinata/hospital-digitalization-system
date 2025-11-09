<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RekamMedis;

class RekamMedisSeeder extends Seeder
{
    public function run()
    {
        // Create 10 medical records, each attached to a few obat items
        RekamMedis::factory()->count(10)->withObat(2)->create();
    }
}
