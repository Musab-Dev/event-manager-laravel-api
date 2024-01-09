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
        return [
            'attendee_info' => new UserResource($this->whenLoaded('user')),
            'registration_date' => $this->created_at->format('d-m-Y h:i:s a'),
        ];
    }
}
