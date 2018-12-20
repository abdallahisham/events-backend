<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Models\Event;
use App\Repositories\Contracts\EventRepository;
use App\Transformers\EventResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class EventsController extends Controller
{
    private $events;

    function __construct(EventRepository $events)
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
        /**
         * @var $events Collection
         */
        $events = $this->events->with(['user'])
            ->orderBy('created_at', 'DESC')
            ->simplePaginate(10);
        $events->transform(function ($event) {
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
                'desc' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)',
                'address' => $event->address,
                'venue' => 'Jeddah International Expo',
                'price' => $event->price,
                'lon' => $event->position_longitude,
                'lat' => $event->position_latitude,
                'user_id' => $event->user->id,
                'user_name' => $event->user->name,
                'image_url' => $event->image_url,
                'user_desc' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)',
                'duration' => $event->duration,
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
        $event = $this->events->create($request->prepared());
        return new EventResponse($event, EventResponse::HTTP_CREATED);
    }

    public function storeImage(Request $request)
    {
        logger()->info('Uploading image');
        $event = Event::findOrFail($request->id);
        $userId = $request->user()->id;
        $fileName = time() . '_' . $userId . '.' . $request->file('file')->getClientOriginalExtension();
        $request->file('file')->storeAs("public/{$userId}", $fileName);
        $event->image = $fileName;
        $event->save();

        return new EventResponse($event, EventResponse::HTTP_OK);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventUpdateRequest $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
