<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\EventResource;
use App\Http\Traits\CanLoadRelations;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    use CanLoadRelations;
    private $availableRelations = ['owner', 'attendees', 'attendees.user'];
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = $this->loadRelations(Event::query());
        return EventResource::collection($events->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:10|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        $event = Event::create([
            ...$data,
            'owner_id' => 1
        ]);

        return new EventResource($this->loadRelations($event));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return new EventResource($this->loadRelations($event));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'sometimes|integer|min:10|max:50',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after:start_date',
            'owner_id' => 'sometimes|integer'
        ]);
        
        $event->update($data);

        return new EventResource($this->loadRelations($event));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        // return response()->json([
        //     'message' => 'Event Deleted Successfully!'
        // ]);

        // common practice => 204 No Content is available
        return response(status: 204);
    }
}
