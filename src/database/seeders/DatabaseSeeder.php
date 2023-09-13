<?php

namespace Database\Seeders;

use Database\Factories\OrderFactory;
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
        ]);

        OrderFactory::new()->count(3)->create();
        ProductFactory::new()->count(3)->create();
    }

}
