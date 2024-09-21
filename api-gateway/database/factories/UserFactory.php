<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), // default password
        ];
    }

    public function withToken()
    {
        return $this->afterCreating(function (User $user) {
            $token = $user->createToken('api-token')->plainTextToken;

            $user->tokens()->latest()->first()->update(['plain_text' => $token]);

            $directoryPath = dirname(__DIR__) . '/api-gateway';
            $filePath = $directoryPath . '/example-token';

            // Ensure the directory exists
            if (!is_dir($directoryPath)) {
                mkdir($directoryPath, 0755, true); // Create the directory if it doesn't exist
            }

            // Write the plain text token to the file
            file_put_contents($filePath, $token);
        });
    }
}
