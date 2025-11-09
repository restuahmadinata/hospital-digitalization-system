<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feedback;

class FeedbackSeeder extends Seeder
{
    public function run()
    {
        // Create 10 feedback items connecting pasien and dokter
        Feedback::factory()->count(10)->create();
    }
}
