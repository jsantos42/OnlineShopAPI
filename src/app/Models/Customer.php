<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function order() {
        return $this->hasOne(Order::class);
    }

    // Should be moved to a service/action and call it from a controller
    protected function placeOrder() {
        //After placing an order, the system should send an email to the
        // customer service to inform them of the received order, and an email
        // to the user to confirm the order with an attached summary file.
    }
}
