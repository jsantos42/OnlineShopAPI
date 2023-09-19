<?php

namespace Database\Seeders;

use Database\Factories\OrderFactory;
use Database\Factories\ProductCategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '123456',
        ]);

        // Creating categories
        $productCategories = ProductCategoryFactory::new()->count(3)->create();

        // Creating customers and orders
        $orders = OrderFactory::new()->count(3)->create();

        $orders->each(function ($order) use ($productCategories) {
            $products = ProductFactory::new()->count(3)->create();

            // Attaching categories to each product
            $products->each(function ($product) use ($productCategories) {
                $product->categories()->attach($productCategories->random(rand(1, 3)));
            });

            // Attaching products to each order
            $order->products()->attach($products);
        });
    }

}
