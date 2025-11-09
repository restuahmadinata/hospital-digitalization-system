<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TindakanMedis;

class TindakanMedisSeeder extends Seeder
{
    public function run()
    {
        // Create 10 tindakan medis entries
        TindakanMedis::factory()->count(10)->create();
    }
}
