<?php

namespace App\Http\Controllers\Api;

use App\Http\Traits\CanLoadRelations;
use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use Illuminate\Support\Facades\Gate;

class AttendeeController extends Controller
{
    use CanLoadRelations;
    private $availableRelations = ['user', 'event'];

    public function __construct() {
        // only protect the routes [store, destroy] (only authenticated users)
        $this->middleware('auth:sanctum')->only(['store', 'destroy']);
        // limit the api calls for [store, destroy] -write actions- (abuse prevention)
        $this->middleware('throttle:api')->only(['store', 'destroy']);

        $this->authorizeResource(Attendee::class, 'attendee');
    }

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
        // store the attendance request to the event for the logged-in user
        $data = [
            'user_id' => $request->user()->id
        ];

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
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Attendee $attendee)
    {
        // if (Gate::denies('delete-attendee', [$event, $attendee])){
        //     abort(403, "you are not authorized to delete this attendee.");
        // }
        
        $attendee->delete();
        
        return response(status: 204);
    }
}
