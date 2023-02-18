<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Siswa;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
        /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Siswa $siswa) {

        })->afterCreating(function (Siswa $siswa) {
            $siswa->setStatus('aktif');
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'wali_id' => fake()->randomElement(User::where('akses', 'wali')->pluck('id')->toArray()),
            'wali_status' => 'ok',
            'nama' => fake()->name(),
            'nisn' => fake()->numberBetween(100000000, 9999999999),
            'jurusan' => 'AKUNTANSI',
            'kelas' => fake()->randomElement(['X', 'XI', 'XII']),
            'angkatan' => fake()->randomElement(['2020','2021', '2022']),
            'user_id' => 1,
            'biaya_id' => 1,
        ];
    }
}
