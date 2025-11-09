<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dokter;

class DokterSeeder extends Seeder
{
    public function run()
    {
        // Create Dokter entries for every user with role 'dokter' that doesn't already have one
        $dokterUsers = User::where('role', 'dokter')->get();

        foreach ($dokterUsers as $user) {
            $exists = Dokter::where('dokter_id', $user->id)->exists();
            if (! $exists) {
                Dokter::factory()->create(['dokter_id' => $user->id]);
            }
        }
    }
}
