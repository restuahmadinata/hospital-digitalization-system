<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $passAdmin = 'admin123';
        $passDokter1 = 'dokter123';
        $passPasien1 = 'pasien123';

        // Admin
        User::create([
            'name' => 'Admin Satu',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make($passAdmin),
            'role' => 'admin',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'pria',
            'email_verified_at' => now(),
        ]);

        // Dokter
        User::create([
            'name' => 'Dokter Satu',
            'username' => 'dokter',
            'email' => 'dokter1@example.com',
            'password' => Hash::make($passDokter1),
            'role' => 'dokter',
            'tanggal_lahir' => '1985-05-12',
            'jenis_kelamin' => 'pria',
            'email_verified_at' => now(),
        ]);

        // Pasien
        User::create([
            'name' => 'Pasien Satu',
            'username' => 'pasien',
            'email' => 'pasien1@example.com',
            'password' => Hash::make($passPasien1),
            'role' => 'pasien',
            'tanggal_lahir' => '1995-02-14',
            'jenis_kelamin' => 'wanita',
            'email_verified_at' => now(),
        ]);
    }
}