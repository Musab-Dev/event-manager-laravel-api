<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
        
        // return [
        //     'id' => $this->id,
        //     'user_id'=>$this->user_id,
        //     'user' => new UserResource($this->whenLoaded('user')),
        //     'event_id' => $this->event_id,
        //     'event' => new EventResource($this->whenLoaded('event')),
        //     'registration_date' => $this->created_at->format('d-m-Y h:i:s a'),
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at,
        // ];
    }
}
