<?php

namespace App\Listeners;

use App\Artwork;
use App\Events\onAddArtworkEvent;
use App\Events\onAddArtwor2kEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddArtworkListener
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
     * @param  onAddArtworkEvent  $event
     * @return void
     */
    public function handle(onAddArtworkEvent $event)
    {
       $artwork = Artwork::create([
            'title' => $event->artwork->title,
            'language_id' => $event->artwork->language,
            'category_id' => $event->artwork->category,
            'description' => $event->artwork->description,
            'image_id' => $event->image_id,
            'user_id' => $event->artwork->user_id,
            'status_id' => $event->artwork->status,
        ]);

        event(new onAddArtwor2kEvent($event,$artwork));
    }
}
