<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'f_name' => fake()->firstName(),
            'l_name' => fake()->lastName(),
            'm_name' => fake()->randomLetter(),
            'location' => fake()->city(),
            'phone_no' => fake()->phoneNumber(),
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->email(),
            'role' => fake()->numberBetween(0, 2), // Adjust roles as needed
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'username_verified_at' => null,
        ]);
    }
}
