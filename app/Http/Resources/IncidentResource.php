<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\UsersResource;

class IncidentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        $carbon = \Carbon\Carbon::now();
        return [
            'id' => $this->id,
            'location' => new LocationResource($this->locations),
            "title" => $this->title,
            'people' => UsersResource::collection($this->people),
            "comments" => $this->comments,
            "incident_date" => date("c", strtotime($this->incident_date)),
            "created_at" => date("c", strtotime($this->created_at)),
            "updated_at" => date("c", strtotime($this->updated_at)),
            
        ];
    }
}
