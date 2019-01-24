<?php

namespace App\Http\Controllers\Admin;

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
        $events = $this->eventRepository->with(['user'])->findWhere(['is_featured' => 1])->all();
        $data = fractal($events, new EventTransformer())->toArray();
        $events = reset($data);
        return view('admin.events.featured.index', compact('events'));
    }

    public function toggle(int $id)
    {
        $event = $this->eventRepository->find($id);
        $this->eventRepository->update([
            'is_featured' => $event->is_featured == 0 ? 1 : 0
        ], $id);

        return back();
    }
}
