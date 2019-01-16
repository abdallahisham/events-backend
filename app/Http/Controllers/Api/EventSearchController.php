<?php

namespace App\Http\Controllers\Api;

use App\Http\Responses\Response;
use App\Repositories\Contracts\EventRepository;
use App\Transformers\EventTransformer;
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
        logger()->info('Searching...');
        $events = $this->events->filter($request);
        return new Response($events, new EventTransformer());
    }
}
