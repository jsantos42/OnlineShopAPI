<?php

namespace App\Jobs;

use App\Mail\ClientConfirmationEmail;
use App\Mail\WarehouseNotificationEmail;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

/**
 * Job to send order confirmation emails.
 */
class SendConfirmationEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The customer ID.
     *
     * @var int
     */
    private $customerId;

    /**
     * Create a new job instance.
     *
     * @param int $customerId
     */
    public function __construct($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * Send the confirmation emails.
     *
     * @return void
     */
    public function handle(): void
    {
        $orderCurrentProducts = Order::with('products')
            ->where('customer_id', $this->customerId)
            ->first()
            ->products()
            ->get()
            ->map(fn($product) => [
                'quantity' => $product->pivot->quantity,
                'name' => $product->name,
                'price' => $product->price,
            ])
        ;

        $customerEmailAddress = Customer::find($this->customerId)->email;
        $warehouseEmailAddress = User::find(1)->email;

        Mail::to($customerEmailAddress)->send(new ClientConfirmationEmail($orderCurrentProducts));
        Mail::to($warehouseEmailAddress)->send(new WarehouseNotificationEmail($orderCurrentProducts));
    }
}
