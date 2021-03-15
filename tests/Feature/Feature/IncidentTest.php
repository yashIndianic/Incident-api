<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncidentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRequiredFieldsForCreateIncident()
    {
        $this->json('POST', 'api/create/incident')
            ->assertStatus(422)
            ->assertJson([
                'comments' => ['The comments field is required.'],
                'incidentDate' => ['The incidentDate field is required.'],
                'category' => ['The category id field is required.'],
                'location.latitude' => ['The latitude field is required.'],
                'location.longitude' => ['The longitude field is required.'],
                'people.*.type' => ['The type field is required.'],
            ]);
    }
    
    public function testForCreateIncidentSuccess() {
        
        $data = [
            "location" => [
                "latitude" => 13.9231501,
                "longitude" => 75.7818517,
            ],
            "title" => "incident title",
            "category" => 1,
            "people" => [
                    [
                    "name" => "abc",
                    "type" => "staff"
                ],
                    [
                    "name" => "xyz",
                    "type" => "witness"
                ],
                    [
                    "name" => "def",
                    "type" => "staff"
                ],
            ],
            "comments" => "This is a string of comments",
            "incident_date" => "2020-09-01T13:26:00+00:00",
            "created_at" => "2021-09-01T13:26:00+00:00",
            "updated_at" => "2021-09-01T13:32:59+01:00"
        ];
        
//dd(json_encode($data));
        $this->json('POST', 'api/create/incident', $data)
            ->assertStatus(201)
            ->assertJsonStructure([ 'data' =>
                ['id', 'title', 'comments','incident_date','created_at','updated_at','people','location']
            ]);
    }
    
    public function testForGetIncident()
    {
        $data = $this->get('api/get/incident')
            ->assertStatus(200)
            ->assertJsonStructure(['data' => [ '*' => ['id', 'title', 'comments','incident_date','created_at','updated_at','people','location']]])
            ->getData();
//        dd($data);
        
        
        
//        $response = $this->get('/api/get/incident');
//
//        $response->assertStatus(200);
    }
    
    
    
    
}
