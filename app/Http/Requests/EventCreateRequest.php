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
            'end_time' => ['required'],
            'address' => ['required'],
            'lat' => ['required'],
            'long' => ['required'],
            'sponsor' => ['required'],
            'type' => ['required'],
            'price' => ['required'],
        ];
    }

    public function prepared()
    {
        $data = [
            'name' => request('name'),
            'description' => request('desc'),
            'start_date' => new Carbon(request('start_date')),
            'end_date' => new Carbon(request('end_date')),
            'start_time' => request('start_time'),
            'end_time' => request('end_time'),
            'address' => request('address'),
            'position_latitude' => request('lat'),
            'position_longitude' => request('long'),
            'has_sponsors' => request('sponsor'),
            'event_type_id' => request('type'),
            'user_id' => request()->user()->id,
            'city_id' => request('city') ?? 1,
            'price' => request('price')
        ];
        return $data;
    }
}
