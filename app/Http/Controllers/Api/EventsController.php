<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Responses\Response;
use App\Http\Responses\ResponseWithCode;
use App\Repositories\Contracts\EventRepository;
use App\Transformers\EventResponse;
use App\Http\Controllers\Controller;
use App\Transformers\EventTransformer;
use Illuminate\Http\Request;

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
     * @return \App\Http\Responses\Response
     */
    public function index()
    {
        logger()->info('Getting events');
        $events = $this->events->with(['user'])
            ->orderBy('created_at', 'DESC')
            ->all();
//            ->simplePaginate(10);

        return new Response($events, new EventTransformer());
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
        logger()->info('Uploading image...');
        $this->events->saveImage($request, $request->id);
        return new ResponseWithCode(200);
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
     * @return \App\Http\Responses\ResponseWithCode
     */
    public function destroy(Request $request)
    {
        $event = $this->events->find($request->id);
        if ($event->user_id == $request->user()->id) {
            $this->events->delete($event->id);
        }
        return new ResponseWithCode(200);
    }
}
