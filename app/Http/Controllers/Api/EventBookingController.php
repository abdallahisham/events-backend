<?php

namespace App\Http\Controllers\Api;

use App\Http\Responses\Response;
use App\Http\Responses\ResponseWithCode;
use App\Services\EventBookingService;
use App\Transformers\EventTransformer;
use App\Http\Controllers\Controller;

class EventBookingController extends Controller
{
    private $bookingService;

    public function __construct(EventBookingService $bookingService)
    {
        $this->middleware('auth:api');
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $userId = auth()->id();
        $bookingList = $this->bookingService->bookedEvents($userId);
        return new Response($bookingList, new EventTransformer());
    }

    public function bookEvent()
    {
        $this->bookingService->bookEvent(request('id'));
        return new ResponseWithCode(200);
    }
}
