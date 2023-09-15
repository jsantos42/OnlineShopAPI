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
        $orderCurrentProducts = Order::with('products')
            ->where('customer_id', $id)
            ->first()
            ->products()
            ->get()
            ->map(fn($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $product->pivot->quantity,
            ])
        ;
        return response()->json($orderCurrentProducts);
    }

    public function addProduct($id, $productId)
    {
        $order = Order::with('products')
            ->where('customer_id', $id)
            ->first();

        $orderCurrentProducts = $order->products()->pluck('id')->toArray();

        if (in_array($productId, $orderCurrentProducts)) {
            $order->products()->find($productId)->pivot->increment('quantity');
        } else {
            $order->products()->attach($productId);
        }

        return response()->json();
    }

    public function removeProduct($id, $productId)
    {
        $order = Order::with('products')
            ->where('customer_id', $id)
            ->first();

        $orderCurrentProducts = $order->products()->pluck('id')->toArray();

        if (in_array($productId, $orderCurrentProducts)) {
            $quantity = $order->products()->find($productId)->pivot->quantity;
            if ($quantity > 1) {
                $order->products()->find($productId)->pivot->decrement('quantity');
            } else {
                $order->products()->detach($productId);
            }
        }

        return response()->json();
    }
}
