<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->realText,
            'category_id' => Category::factory(),
            'sku' => $this->faker->unique()->uuid,
            'price' => $this->faker->randomFloat(2, 5, 1000),
            'quantity' => $this->faker->numberBetween(1, 100),
        ];
    }
}
