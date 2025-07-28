<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Laptop',
                'description' => 'High-performance laptop with 16GB RAM and 512GB SSD',
                'price' => 1299.99,
                'stock' => 10,
            ],
            [
                'name' => 'Smartphone',
                'description' => 'Latest smartphone with 5G connectivity',
                'price' => 899.99,
                'stock' => 15,
            ],
            [
                'name' => 'Wireless Headphones',
                'description' => 'Noise-canceling wireless headphones',
                'price' => 299.99,
                'stock' => 20,
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'Fitness tracking smart watch with heart rate monitor',
                'price' => 399.99,
                'stock' => 25,
            ],
            [
                'name' => 'Tablet',
                'description' => '10-inch tablet with stylus support',
                'price' => 599.99,
                'stock' => 12,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}