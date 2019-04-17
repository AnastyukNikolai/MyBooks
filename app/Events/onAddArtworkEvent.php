<?php

namespace App\Events;

use App\Http\Requests\AddArtworkRequest;
use App\Image;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class onAddArtworkEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $artwork;
    public $image_id;

    public function __construct(AddArtworkRequest $request, Image $image)
    {
        $this->artwork=$request;
        $this->image_id=$image->id;
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
