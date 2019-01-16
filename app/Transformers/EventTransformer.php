<?php

namespace App\Transformers;

use App\Models\Event;
use Jenssegers\Date\Date;

class EventTransformer extends BaseTransformer
{
    /**
     * @param $event Event
     * @return array
     */
    public function transform($event)
    {
        $user = request()->user('api') ?? false;
        Date::setLocale('ar');
        $arStartDate = new Date($event->start_date->format('Y-m-d'));
        $arEndDate = new Date($event->end_date->format('Y-m-d'));
        return [
            'id' => $event->id,
            'name' => $event->name,
            'start_date' => $arStartDate->format('l d F'),
            'end_date' => $arEndDate->format('l d F'),
            'start_date_en' => $event->start_date->format('D d M'),
            'end_date_en' => $event->end_date->format('D d M'),
            'start_time' => $event->start_time_format,
            'end_time' => $event->end_time_format,
            'desc' => $event->description ?? '',
            'address' => $event->address ?? '',
            'venue' => $event->venue ?? '',
            'price' => $event->price ?? 0,
            'lon' => $event->position_longitude,
            'lat' => $event->position_latitude,
            'user_id' => $event->user->id,
            'user_name' => $event->user->name,
            'image_url' => $event->image_url,
            'user_desc' => $event->user->desc ?? '',
            'duration' => $event->duration,
            'is_liked' => $user ? $user->favorites->where('id', $event->id)->count() : 0,
            'is_booked' => $user ? $user->booking->where('id', $event->id)->count() : 0
        ];
    }
}