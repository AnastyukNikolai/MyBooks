<?php

namespace App\Listeners;

use App\Events\onPublishAnonsEvent;
use App\Financial_operation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PublishAnonsListener
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
     * @param  onPublishAnonsEvent  $event
     * @return void
     */
    public function handle(onPublishAnonsEvent $event)
    {
        $operations = Financial_operation::where('receiver_id', $event->chapter->artwork->user->id)
            ->where('status_id', 3)
            ->where('type_id', 2)
            ->get();
        foreach ($operations as $operation) {
            if($operation->chapter->chapter_id == $event->chapter->id) {
                $operation->update([
                    'status_id' => 1,
                ])->save();
            }
        }
    }
}
