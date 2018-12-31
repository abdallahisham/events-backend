<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use InvalidArgumentException;

class EventUpdateRequest extends FormRequest
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
            //
        ];
    }

    public function prepared()
    {
        try {
            $start_date = Carbon::createFromFormat('D d M', request('start_date'));
        } catch (InvalidArgumentException $e) {
            logger()->info('End: ' . request('start_date'));
            $start_date = new Carbon(request('start_date'));
        }
        try {
            $end_date = Carbon::createFromFormat('D d M', request('end_date'));
        } catch (InvalidArgumentException $e) {
            logger()->info('End: ' . request('end_date'));
            $end_date = new Carbon(request('end_date'));
        }
        try {
            $start_time = Carbon::createFromFormat('H:i A', request('start_time'));
        } catch (InvalidArgumentException $e) {
            logger()->info('End: ' . request('start_time'));
            $start_time = new Carbon(request('start_time'));
        }
        try {
            $end_time = Carbon::createFromFormat('H:i A', request('end_time'));
        } catch (InvalidArgumentException $e) {
            logger()->info('End: ' . request('end_time'));
            $end_time = new Carbon(request('end_time'));
        }

        $data = [
            'name' => request('name'),
            'description' => request('desc'),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
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
