<?php

namespace App\Http\Requests;

//use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\FormRequest;

class IncidentRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                    'comments' => 'required',
                    'incident_date' => 'required',
                    'category' => 'required|exists:categories,id',
                    'location.latitude' => 'required',
                    'location.longitude' => 'required',
                    'people.*.type' => 'required|in:staff,witness',
        ];
    }
    
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages() {
        return [
            'comments.required' => 'Latitude Is Required',
                    'category.required' => 'Latitude Is Required',
                    'category.exists' => 'Please enter valid category',
                    'location.latitude.required' => 'Latitude Is Required',
                    'location.longitude.required' => 'Longitude Is Required',
                    'people.*.type.in' => 'Please enter valid type',
        ];
    }
}
