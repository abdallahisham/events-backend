<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Contracts\EventRepository;
use App\Transformers\EventResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventSearchController extends Controller
{
    private $events;
    public function __construct(EventRepository $events)
    {
        $this->events = $events;
    }

    public function index(Request $request)
    {
        $events = $this->events->filter($request);
        return new EventResponse($events, EventResponse::HTTP_OK);
    }
}
