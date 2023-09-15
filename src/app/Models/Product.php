<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Product extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
