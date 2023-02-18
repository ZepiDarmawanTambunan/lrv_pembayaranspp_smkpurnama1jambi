<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->unique()->name();
        return [
            'name' => $name,
            'email' => str_replace(' ', '', $name).'@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('1'), // 1
            'remember_token' => Str::random(10),
            'akses' => 'wali',
            'nohp' => '08'.fake()->numerify("##########"),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
