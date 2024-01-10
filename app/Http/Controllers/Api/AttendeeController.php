<?php

namespace App\Http\Controllers\Api;

use App\Http\Traits\CanLoadRelations;
use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;

class AttendeeController extends Controller
{
    use CanLoadRelations;
    private $availableRelations = ['user', 'event'];

    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        // $attendees = $event->attendees()->with('user')->latest();
        $attendees = $this->loadRelations($event->attendees());

        return AttendeeResource::collection($attendees->latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
        ]);

        $attendee = $event->attendees()->create($data);

        return new AttendeeResource($this->loadRelations($attendee));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Attendee $attendee)
    {
        return new AttendeeResource($this->loadRelations($attendee));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event, Attendee $attendee)
    {
        $data = $request->validate([
            'user_id' => 'sometimes|integer',
            'event_id' => 'sometimes|integer'
        ]);

        $attendee->update($data);

        return new AttendeeResource($this->loadRelations($attendee));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Attendee $attendee)
    {
        $attendee->delete();
        
        return response(status: 204);
    }
}
