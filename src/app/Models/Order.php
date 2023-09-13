<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function addProduct(Product $product)
    {
        $this->products()->attach($product->id);
    }

    public function removeProduct(Product $product)
    {
        $this->products()->detach($product->id);
    }
}
