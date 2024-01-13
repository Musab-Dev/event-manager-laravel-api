<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Notifications\EventRemainderNotificaiton;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class SendEventRemainders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-remainders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification emails to attendees whose event is with in the next 24 hours.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $eventsInNext24Hours = Event::with('attendees.user')->whereBetween('start_date', [now(), now()->addDay()])->get();
        $eventsCount = $eventsInNext24Hours->count();
        $eventLabel = Str::plural('event', $eventsCount);
        $this->info("Found {$eventsCount} {$eventLabel} in the next 24 hours.\n");

        foreach($eventsInNext24Hours as $event){
            $this->info("\nEvent {$event->name}:\n");
            foreach ($event->attendees as $attendee){
                $this->info("notifying the user \t{$attendee->user->name}.");

                $attendee->user->notify(new EventRemainderNotificaiton($attendee->user, $event));
            }
        }
        
        $this->info("\nemail remainders sent successfully!");
    }
}
