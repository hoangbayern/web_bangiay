<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;
    use WithFaker;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElements(
                [
                    'ADIDAS',
                    'MLB',
                    'CONVERSE',
                    'GUCCI',
                    'NIKE',
                    'SOCCER',
                ]
            )[0],
            'description' => $this->faker->text($maxNbChars = 200),
        ];
    }
}
