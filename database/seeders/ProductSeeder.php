<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()->create([
            'name' => 'Fifa 2012',
            'category_id' => optional(Category::whereName('Games')->first())->id,
            'sku' => 'A0001',
            'price' => 69.99,
            'quantity' => 20,
        ]);
        Product::factory()->create([
            'name' => 'Assasin\'s Creed 5',
            'category_id' => optional(Category::whereName('Games')->first())->id,
            'sku' => 'A0002',
            'price' => 79.99,
            'quantity' => 15,
        ]);
        Product::factory()->create([
            'name' => 'Asus Zenbook 13" - Aluminum',
            'category_id' => optional(Category::whereName('Computers')->first())->id,
            'sku' => 'A0003',
            'price' => 1399.99,
            'quantity' => 10,
        ]);
        Product::factory()->create([
            'name' => 'Sony UHD HDR 55" 4k TV',
            'category_id' => optional(Category::whereName('TVs and Accessories')->first())->id,
            'sku' => 'A0004',
            'price' => 2399.99,
            'quantity' => 5,
        ]);
    }
}
