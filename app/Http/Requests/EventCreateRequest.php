<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class EventCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'name' => ['required'],
            'desc' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required', 'after_or_equal:start_date'],
            'start_time' => ['required'],
            'address' => ['required'],
            'lat' => ['required'],
            'long' => ['required'],
            'sponsor' => ['required'],
            'type' => ['required'],
        ];
    }

    public function prepared()
    {
        $data = [
            'name' => $this->request->get('name'),
            'description' => $this->request->get('desc'),
            'start_date' => new Carbon($this->request->get('start_date')),
            'end_date' => new Carbon($this->request->get('end_date')),
            'start_time' => $this->request->get('start_time'),
            'end_time' => $this->request->get('end_time'),
            'address' => $this->request->get('address'),
            'position_latitude' => $this->request->get('lat'),
            'position_longitude' => $this->request->get('long'),
            'has_sponsors' => $this->request->get('sponsor'),
            'event_type_id' => $this->request->get('type'),
            'user_id' => request()->user()->id,
            'city_id' => request('city') ?? 1
        ];
        return $data;
    }
}
