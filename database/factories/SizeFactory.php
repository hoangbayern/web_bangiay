<?php

namespace Database\Factories;

use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Size>
 */
class SizeFactory extends Factory
{
    protected $model = Size::class;
    use WithFaker;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->numberBetween($min = 35, $max = 45),
        ];
    }
}
