<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users first (admins, dokter, pasien)
        $this->call(UserSeeder::class);

        // Create dokter model entries linked to dokter users
        $this->call(DokterSeeder::class);

        // Create obat, jadwal, appointments, records and feedback using factories
        $this->call(ObatSeeder::class);
        $this->call(JadwalTugasSeeder::class);
        $this->call(PenjadwalanKonsultasiSeeder::class);
        $this->call(RekamMedisSeeder::class);
        $this->call(TindakanMedisSeeder::class);
        $this->call(FeedbackSeeder::class);
    }
}