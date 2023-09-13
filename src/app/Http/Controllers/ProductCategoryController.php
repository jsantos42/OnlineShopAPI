<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ProductCategoryController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index($id)
    {
        $products = Product::whereHas('categories', function($category) use ($id) {
                $category->where('product_category_id', $id);
            })
                    ->select(['name', 'price'])
                    ->get()
        ;
        return response()->json($products);
    }
}
