<?php

namespace App\Http\Controllers\Api;

use App\Transformers\EventResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserEventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        logger()->info("Getting {$request->user()->email}'s events");
        /**
         * @var $user \App\User
         */
        $user = $request->user();

        $events = $user->events;

        $events->transform(function ($event) use ($user) {
            /**
             * @var $event /App/Models/Event
             */
            return [
                'id' => $event->id,
                'name' => $event->name,
                'start_date' => $event->start_date->format('D d M'),
                'end_date' => $event->end_date->format('D d M'),
                'start_time' => $event->start_time_format,
                'end_time' => $event->end_time_format,
                'desc' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)',
                'address' => $event->address,
                'venue' => 'Jeddah International Expo',
                'price' => $event->price ?? 0,
                'lon' => $event->position_longitude,
                'lat' => $event->position_latitude,
                'user_id' => $event->user->id,
                'user_name' => $event->user->name,
                'image_url' => $event->image_url,
                'user_desc' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)',
                'duration' => $event->duration,
                'is_liked' => $user ? $user->favorites->where('id', $event->id)->count() : 0,
                'is_booked' => $user ? $user->booking->where('id', $event->id)->count() : 0
            ];
        });

        return [
            'response' => [
                'httpCode' => 200,
                'data' => $events
            ]
        ];
    }
}