<?php

namespace GrassFeria\StarterkidBlog\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'name' => $this->faker->name(),
            // 'email' => $this->faker->unique()->safeEmail(),
            // 'age' => $this->faker->numberBetween($min = 18, $max = 90),
            // 'phone' => $this->faker->phoneNumber(),
            // 'address' => $this->faker->address(),
            // 'date_of_birth' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            // 'text' => $this->faker->text($maxNbChars = 200),
            // 'boolean' => $this->faker->boolean($chanceOfGettingTrue = 50),
            // 'password' => $this->faker->password(),
            // 'rememberToken' => $this->faker->md5(),
            // 'createdAt' => $this->faker->dateTimeThisDecade($max = 'now', $timezone = null),
            // 'updatedAt' => $this->faker->dateTimeThisYear($max = 'now', $timezone = null),
            // 'company' => $this->faker->company(),
            // 'uuid' => $this->faker->uuid(),
            // 'user_id' => User::factory(),
        ];
    }
}