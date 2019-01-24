<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Responses\Response;
use App\Http\Responses\ResponseWithCode;
use App\Repositories\Contracts\EventRepository;
use App\Repositories\Contracts\UserRepository;
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

    public function index()
    {
        $events = $this->events->with(['user'])
            ->orderBy('created_at', 'DESC')
            ->all();
//            ->simplePaginate(10);

        return new Response($events, new EventTransformer());
    }

    public function store(EventCreateRequest $request)
    {
        $event = $this->events->create($request->prepared());
        return new EventResponse($event, EventResponse::HTTP_CREATED);
    }

    public function storeImage(Request $request)
    {
        $this->events->saveImage($request, $request->id);
        return new ResponseWithCode(200);
    }

    public function show($id)
    {
        $event = $this->events->with(['user'])->find($id);
        return new EventResponse($event);
    }

    public function update(EventUpdateRequest $request)
    {
        $event = $this->events->find($request->id);
        $this->events->update($request->prepared(), $event->id);
        return new EventResponse($event, 200);
    }

    public function destroy(Request $request, UserRepository $userRepository)
    {
        $event = $this->events->find($request->id);
        if ($event->user_id == $userRepository->authenticatedUserId()) {
            $this->events->delete($event->id);
        }
        return new ResponseWithCode(200);
    }
}
