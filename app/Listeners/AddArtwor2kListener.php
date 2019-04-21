<?php

namespace App\Listeners;

use App\Events\onAddArtwor2kEvent;
use App\Work_genre;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddArtwor2kListener
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
     * @param  onAddArtwor2kEvent  $event
     * @return void
     */
    public function handle(onAddArtwor2kEvent $event)
    {
        foreach ($event->genres as $genre_id) {
            Work_genre::create([
                'artwork_id' => $event->artwork_id,
                'genre_id' => $genre_id,
            ]);
        }
    }
}
