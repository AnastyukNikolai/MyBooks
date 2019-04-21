<?php

namespace App\Events;

use App\Artwork;
use App\Events\onAddArtworkEvent;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class onAddArtwor2kEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $artwork_id;
    public $genres;

    public function __construct(onAddArtworkEvent $event, Artwork $artwork)
    {
        $this->genres=$event->artwork->genres;
        $this->artwork_id=$artwork->id;
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
