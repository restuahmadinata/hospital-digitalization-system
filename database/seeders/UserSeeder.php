<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dokter;
use App\Models\JadwalTugas;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create a stable admin account
        User::create([
            'name' => 'Admin Satu',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'pria',
            'foto' => 'images/users/user-placeholder.png',
            'email_verified_at' => now(),
        ]);

        // Create one stable dokter account
        $dokterStable = User::create([
            'name' => 'Dr. Ahmad Satu',
            'username' => 'dokter1',
            'email' => 'dokter1@example.com',
            'password' => Hash::make('dokter123'),
            'role' => 'dokter',
            'tanggal_lahir' => '1980-05-10',
            'jenis_kelamin' => 'pria',
            'foto' => 'images/users/user-placeholder.png',
            'email_verified_at' => now(),
        ]);

        // Ensure there is a Dokter model for the stable dokter account
        Dokter::factory()->create(['dokter_id' => $dokterStable->id]);

        // Create one stable pasien (patient) account
        User::create([
            'name' => 'Pasien Satu',
            'username' => 'pasien1',
            'email' => 'pasien1@example.com',
            'password' => Hash::make('pasien123'),
            'role' => 'pasien',
            'tanggal_lahir' => '1995-03-15',
            'jenis_kelamin' => 'wanita',
            'foto' => 'images/users/user-placeholder.png',
            'email_verified_at' => now(),
        ]);

        // Create dokter users (3) and pasien users (6) — total 10 users including admin above
        $dokterUsers = User::factory()->count(3)->dokter()->create();
        $pasienUsers = User::factory()->count(6)->pasien()->create();

        // Ensure there is a Dokter model for each dokter user (DokterSeeder will also cover this, but create one here for immediate consistency)
        foreach ($dokterUsers as $dokterUser) {
            Dokter::factory()->create(['dokter_id' => $dokterUser->id]);
        }
    }
}