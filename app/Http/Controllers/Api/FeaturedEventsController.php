<?php

namespace App\Http\Controllers\Api;

use App\Http\Responses\Response;
use App\Http\Controllers\Controller;
use App\Transformers\EventTransformer;
use App\Repositories\Contracts\EventRepository;

class FeaturedEventsController extends Controller
{
    protected $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function index()
    {
        $events = $this->eventRepository->findWhere(['is_featured' => 1])->all();
        return new Response($events, new EventTransformer());
    }
}
