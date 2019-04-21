<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\onAddArtworkEvent' => [
            'App\Listeners\AddArtworkListener',
        ],
        'App\Events\onAddArtwor2kEvent' => [
            'App\Listeners\AddArtwor2kListener',
        ],
        'App\Events\onAddArtwor3kEvent' => [
            'App\Listeners\AddArtwor3kListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
