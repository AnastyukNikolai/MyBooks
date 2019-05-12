<?php

namespace App\Listeners;

use App\Events\onAddFinancialOperationEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddFinancialOperationListener
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
     * @param  onAddFinancialOperationEvent  $event
     * @return void
     */
    public function handle(onAddFinancialOperationEvent $event)
    {
        $event->payer->update([
            'balance' => $event->payer_new_balance,
        ]);

        $event->receiver->update([
            'balance' => $event->receiver_new_balance,
        ]);
       return true;
    }
}
