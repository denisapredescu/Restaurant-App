<?php

namespace App\Listeners;

use App\Events\OrderPaidEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderPaidNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderPaidEvent  $event
     * @return void
     */
    public function handle(OrderPaidEvent $event)
    {
        $count = $event->order->dishes()->sum('quantity');
        echo 'Order with id ' . $event->order->id . ' has ' . $count . ' dishes ' . 'and costs '. $event->order->total . PHP_EOL;
    }
}
