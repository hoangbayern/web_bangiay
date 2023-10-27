<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory(50)
            ->create()
            ->each(function ($u) {
                $u->colors()->attach(Color::pluck('id')->take(rand(1, 10)));
                $u->sizes()->attach(Size::pluck('id')->take(rand(1, 10)));
            });
    }
}
