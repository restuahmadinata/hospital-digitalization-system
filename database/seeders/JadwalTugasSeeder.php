<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalTugas;

class JadwalTugasSeeder extends Seeder
{
    public function run()
    {
        // Create 10 schedule entries tied to existing dokter users
        JadwalTugas::factory()->count(10)->create();
    }
}
