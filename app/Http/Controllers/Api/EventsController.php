<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Models\Event;
use App\Repositories\Contracts\EventRepository;
use App\Transformers\EventResponse;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class EventsController extends Controller
{
    private $events;

    public function __construct(EventRepository $events)
    {
        $this->events = $events;
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        logger()->info('Getting events');
        /**
         * @var $events Collection
         */
        $events = $this->events->with(['user'])
            ->orderBy('created_at', 'DESC')
            ->simplePaginate(10);

        /**
         * @var $user User
         */
        $user = request()->user('api') ?? false;

        $events->transform(function ($event) use ($user) {
            /**
             * @var $event Event
             */
            return [
                'id' => $event->id,
                'name' => $event->name,
                'start_date' => $event->start_date->format('D d M'),
                'end_date' => $event->end_date->format('D d M'),
                'start_time' => $event->start_time_format,
                'end_time' => $event->end_time_format,
                'desc' => $event->description ?? '',
                'address' => $event->address,
                'venue' => 'Jeddah International Expo',
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
        });
        return new EventResponse($events, EventResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EventCreateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EventCreateRequest $request)
    {
        logger()->info('Adding event..');
        $event = $this->events->create($request->prepared());
        return new EventResponse($event, EventResponse::HTTP_CREATED);
    }

    public function storeImage(Request $request)
    {
        logger()->info('Uploading image');
        $this->events->saveImage($request, $request->id);
        return new EventResponse([], EventResponse::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $event = $this->events->with(['user'])->find($id);
        return new EventResponse($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EventUpdateRequest  $request
     * @return EventResponse
     */
    public function update(EventUpdateRequest $request)
    {
        logger()->info('Updating ' . $request->id);
        $event = $this->events->find($request->id);
        $this->events->update($request->prepared(), $event->id);
        return new EventResponse($event, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return EventResponse
     */
    public function destroy(Request $request)
    {
        $event = $this->events->find($request->id);
        if ($event->user_id == $request->user()->id) {
            $this->events->delete($event->id);
        }
        return new EventResponse([], 200);
    }
}
