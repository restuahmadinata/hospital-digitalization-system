<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'role' => $this->faker->randomElement(['dokter', 'pasien']),
            'tanggal_lahir' => $this->faker->date(),
            'jenis_kelamin' => $this->faker->randomElement(['pria', 'wanita']),
        ];
    }

    /**
     * State for role Dokter
     */
    public function dokter()
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'dokter',
        ]);
    }

    /**
     * State for role Pasien
     */
    public function pasien()
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'pasien',
        ]);
    }
}