<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Obat;
use App\Models\Dokter;
use App\Models\Feedback;
use App\Models\RekamMedis;
use App\Models\JadwalTugas;
use App\Models\TindakanMedis;
use App\Models\PenjadwalanKonsultasi;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);

        User::factory()->count(50)->create();
        Obat::factory()->count(20)->create();
        Dokter::factory()->count(20)->create();
        Feedback::factory()->count(20)->create();
        JadwalTugas::factory()->count(20)->create();
        RekamMedis::factory()
            ->count(15)
            ->hasAttached(Obat::inRandomOrder()->limit(3)->get())
            ->create();
        PenjadwalanKonsultasi::factory()->count(15)->create();
        TindakanMedis::factory()->count(20)->create();
    }
}