<?php

namespace App\Events;

use App\Financial_operation;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class onAddFinancialOperationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $payer;
    public $receiver;
    public $payer_new_balance;
    public $receiver_new_balance;

    public function __construct(Financial_operation $operation)
    {
        $this->payer = User::find($operation->payer_id);
        $this->receiver = User::find($operation->receiver_id);
        $this->payer_new_balance = $this->payer->balance-$operation->amount;
        $this->receiver_new_balance = $this->receiver->balance+$operation->amount;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
