<?php

namespace Tests\Feature;

use Database\Factories\OrderFactory;
use Database\Factories\ProductCategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TestRoutes extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function setUp(): void
    {
        parent::setUp();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'a@a.com',
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

    public function test_can_get_orders(): void
    {
        $response = $this->get('/api/customers/2/order/');
        $response->assertStatus(200);

        $orders = json_decode($response->getContent());
        $this->assertEquals(count($orders), 3);
    }

    public function test_can_get_products(): void
    {
        $response = $this->get('/api/products/');
        $response->assertStatus(200);

        $products = json_decode($response->getContent());
        var_dump($products);
        $this->assertEquals(count($products), 9);
    }
}
