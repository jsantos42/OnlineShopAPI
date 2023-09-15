<?php

namespace App\Http\Controllers;

use App\Jobs\SendConfirmationEmails;
use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Controller for order management.
 */
class OrderController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Get a customer's order.
     *
     * @param int $id Customer ID
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Add product to customer's order.
     *
     * @param int $id Customer ID
     * @param int $productId Product ID
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Remove product from customer's order.
     *
     * @param int $id Customer ID
     * @param int $productId Product ID
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Place customer's order.
     *
     * @param int $id Customer ID
     * @return void
     */
    public function placeOrder($id)
    {
        Order::with('products')
            ->where('customer_id', $id)
            ->update(['placed' => true]);

        SendConfirmationEmails::dispatch($id);
    }
}
