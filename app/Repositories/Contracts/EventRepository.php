<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface EventRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface EventRepository extends RepositoryInterface
{
    public function filter(Request $request);

    public function getEventsTypes(): array;

    public function saveImage(Request $request, int $id);

    const THIS_DAY = 0;
    const THIS_WEEK = 1;
    const THIS_MONTH = 2;
    const THIS_YEAR = 3;

    const TYPE_ANYTHING = 0;
    const TYPE_VOICE_EVENT = 1;
    const TYPE_FOOD_AND_DRINK = 2;
    const TYPE_HACKATHON = 3;
    const TYPE_TECHNICAL = 4;
    const TYPE_ART_AND_ENTERTAINMENT = 5;
    const TYPE_GAMES = 6;
    const TYPE_EDUCATION = 7;
    const TYPE_ENTREPRENEUR = 8;
    const TYPE_HEALTH = 9;
    const TYPE_CRAFTS = 10;
    const TYPE_TOURISM = 11;
    const TYPE_RELIGIOUS = 12;
}
