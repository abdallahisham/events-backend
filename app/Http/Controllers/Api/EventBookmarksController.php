<?php

namespace App\Http\Controllers\Api;

use App\Http\Responses\Response;
use App\Http\Responses\ResponseWithCode;
use App\Services\EventBookingService;
use App\Transformers\EventTransformer;
use App\Http\Controllers\Controller;

class EventBookmarksController extends Controller
{
    private $bookingService;

    public function __construct(EventBookingService $bookingService)
    {
        $this->middleware('auth:api');
        $this->bookingService = $bookingService;
    }

    public function bookmarks()
    {
        $userId = auth()->id();
        $favorites = $this->bookingService->likedEvents($userId);
        return new Response($favorites, new EventTransformer());
    }

    public function bookmark()
    {
        $this->bookingService->likeEvent(request('id'));
        return new ResponseWithCode(200);
    }
}
