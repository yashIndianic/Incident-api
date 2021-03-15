<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\IncidentRequest;
use App\Incident;

class IncidentController extends Controller
{
    /**
     * @desc Create new Incident
     * @param IncidentRequest $request
     * @return type
     */
    public function createIncident(IncidentRequest $request) {
        $data = $request->all();
        $incident = new Incident();
        $incident->title = $data['title'];
        $incident->category_id = $data['category'];
        $incident->comments = $data['comments'];
        $incident->incident_date = gmdate('Y-m-d H:i:s', strtotime(str_replace('/', '-', $data['incident_date'])));
        $incident->created_at = (!is_null($data['created_at'])) ? date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $data['created_at']))) : \Carbon\Carbon::now();
        $incident->updated_at = (!is_null($data['updated_at'])) ? date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $data['updated_at']))) : \Carbon\Carbon::now();
        $incident->save();
        $location = new \App\Location();
        $location->latitude = $data['location']['latitude'];
        $location->longitude = $data['location']['longitude'];
        $location->incident_id = $incident->id;
        $location->save();
        foreach ($data['people'] as $people) {
            $user = new \App\User();
            $user->name = $people['name'];
            $user->type = $people['type'];
            $user->incident_id = $incident->id;
            $user->save();
        }

        $incidents = $incident->refresh();
        return $data = (new \App\Http\Resources\IncidentResource($incidents));
    }

    /**
     * @desc For Get all Incident
     * @return type
     */
    public function getAllIncident() {
        $incidents = Incident::with('locations', 'people')->get();
        return \App\Http\Resources\IncidentResource::collection($incidents);
    }
}
