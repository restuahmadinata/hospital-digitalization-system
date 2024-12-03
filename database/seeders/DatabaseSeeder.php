<?php

namespace Database\Seeders;

use App\Models\Obat;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Feedback;
use App\Models\RekamMedis;
use App\Models\JadwalTugas;
use App\Models\TindakanMedis;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\PenjadwalanKonsultasi;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
        ->create([
            'name' => 'Admin Satu',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'pria',
            'foto' => 'images/users/user_placeholder.png',
            'email_verified_at' => now(),
        ]);

        User::factory()
            ->create([
                'name' => 'Dokter Strange',
                'username' => 'dokter',
                'email' => 'dokter@example.com',
                'password' => Hash::make('dokter123'),
                'role' => 'dokter',
                'tanggal_lahir' => '1985-05-12',
                'jenis_kelamin' => 'pria',
                'foto' => 'images/users/user_placeholder.png',
                'email_verified_at' => now(),
            ])

            ->each(function ($user) {
                
                if ($user->role === 'dokter') {
                    $dokter = Dokter::factory()->create(['dokter_id' => $user->id]);
            
                    JadwalTugas::factory()->create([
                        'dokter_id' => $dokter->id,
                        'hari_tugas' => 'Senin',
                    ]);
                }
            });

        User::factory()
            ->create([
            'name' => 'Orang Sakit',
            'username' => 'pasien',
            'email' => 'pasien@example.com',
            'password' => Hash::make('pasien123'),
            'role' => 'pasien',
            'tanggal_lahir' => '1995-02-14',
            'jenis_kelamin' => 'wanita',
            'foto' => 'images/users/user_placeholder.png',
            'email_verified_at' => now()
            ]);

        Obat::factory()->count(20)->create();
    }
}