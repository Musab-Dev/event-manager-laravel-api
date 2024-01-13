<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Attendee;
use App\Models\Event;
use App\Policies\AttendeePolicy;
use App\Policies\EventPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Event::class => EventPolicy::class,
        Attendee::class => AttendeePolicy::class, 
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // authorization are moved to policy classes
        // gates are used for general purpose authorization (application-wide authorization)
        // when the authorization is specific to model actions then it's better to user policies
        
        // Gate::define('update-event', function ($user, Event $event) {
        //     return $user->id === $event->owner_id;
        // });

        // Gate::define('delete-attendee', function ($user, Event $event, Attendee $attendee) {
        //     return $user->id === $event->owner_id || $user->id === $attendee->user_id;
        // });
    }
}
