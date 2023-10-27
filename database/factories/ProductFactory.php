<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    use WithFaker;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Nike ' . $this->faker->word . ' ' . $this->faker->lexify('???'),
            'price' => $this->faker->numberBetween($min = 10, $max = 200),
            'gender' => rand(0, 1),
            'description' => $this->faker->text($maxNbChars = 200),
            'image' => json_encode([
                'product' . $this->faker->numberBetween($min = 1, $max = 15) . '.jpg',
                'product' . $this->faker->numberBetween($min = 1, $max = 15) . '.jpg',
                'product' . $this->faker->numberBetween($min = 1, $max = 15) . '.jpg',
            ]),
            'category_id' => Category::all()->random()->id,
        ];
    }
}
