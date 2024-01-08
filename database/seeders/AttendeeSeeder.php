<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttendeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $events = Event::all();

        foreach($users as $user){

            $numberOfEventsToAttend = random_int(1,5);
            $eventsToAttend = $events->random($numberOfEventsToAttend);

            foreach($eventsToAttend as $event){
                Attendee::create([
                    'event_id' => $event->id,
                    'user_id' => $user->id
                ]);
            }
        }
    }
}
