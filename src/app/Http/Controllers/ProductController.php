<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Controller for product management.
 */
class ProductController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Get all products.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Product::all());
    }
}
