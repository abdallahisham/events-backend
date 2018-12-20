<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\EventRepository;
use App\Models\Event;

/**
 * Class EventRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EventRepositoryEloquent extends BaseRepository implements EventRepository
{
    private $eventTypes = [
        'anything',
        'Voice event',
        'Food and drink',
        'Hackathon',
        'Technical',
        'Art and entertainment',
        'Games',
        'Education',
        'Entrepreneur',
        'Health',
        'Crafts',
        'Tourism',
        'Religious',
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Event::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function filter(Request $request)
    {
        dump($request->all());
        return $this->orderBy('created_at', 'desc')->simplePaginate(10);
    }

    public function getEventsTypes(): array
    {
        return $this->eventTypes;
    }
}
