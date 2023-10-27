<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    protected $model = Profile::class;
    use WithFaker;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'avatar' => $this->faker->imageUrl($width = 480, $height = 480),
            'birthday' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'gender' => rand(0, 1),
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->streetAddress,
        ];
    }
}
