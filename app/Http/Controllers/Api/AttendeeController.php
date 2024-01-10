<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;

class AttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $attendees = $event->attendees()->with('user')->latest();

        return AttendeeResource::collection($attendees->paginate(10));
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

        return new AttendeeResource($attendee->load(['user', 'event']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Attendee $attendee)
    {
        return new AttendeeResource($attendee->load(['user', 'event']));
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

        return new AttendeeResource($attendee->load(['user', 'event']));
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
