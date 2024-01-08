<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        for ($i =  0; $i < 200; $i++){
            $user = $users->random();
            Event::factory()->create([
                'owner_id' => $user->id
            ]);
        }
    }
}
