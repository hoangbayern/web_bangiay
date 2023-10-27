<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;
    use WithFaker;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'body' => $this->faker->text($maxNbChars = 200),
            'rating' => $this->faker->numberBetween($min = 1, $max = 5),
            'product_id' => Product::all()->random()->id,
            'user_id' => User::all()->random()->id,
        ];
    }
}
