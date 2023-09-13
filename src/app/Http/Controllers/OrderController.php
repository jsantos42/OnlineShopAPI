<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class OrderController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index($id)
    {
        $order = Order::with('products')
            ->where('customer_id', $id)
            ->first()
            ->products()
            ->select(['name', 'price'])
            ->get()
            ->map
            ->only(['name', 'price'])
        ;
        return response()->json($order);
    }
}
