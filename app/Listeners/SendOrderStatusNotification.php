<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use App\Mail\OrderConfirmed;
use App\Mail\OrderPaid;
use App\Mail\OrderShipped;
use App\Mail\OrderDelivered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderStatusNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(OrderStatusChanged $event): void
    {
        $order = $event->order;
        $newStatus = $event->newStatus;

        // Send appropriate email based on status change
        match ($newStatus) {
            'confirmed' => Mail::queue(new OrderConfirmed($order)),
            'paid' => Mail::queue(new OrderPaid($order)),
            'shipped' => Mail::queue(new OrderShipped($order)),
            'delivered' => Mail::queue(new OrderDelivered($order)),
            default => null,
        };
    }
}
