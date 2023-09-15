<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Controller for product categories.
 */
class ProductCategoryController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Get products for a category.
     *
     * @param int $id Category ID
     * @return \Illuminate\Http\JsonResponse
     */
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
