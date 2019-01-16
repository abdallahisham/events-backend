<?php

namespace App\Http\Controllers\Api;

use App\Http\Responses\Response;
use App\Transformers\EventTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserEventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        logger()->info("Getting {$request->user()->email}'s events");
        $events = $request->user()->events;
        return new Response($events, new EventTransformer());
    }
}
