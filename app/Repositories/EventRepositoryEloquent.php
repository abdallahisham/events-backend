<?php

namespace App\Repositories;

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
        if ($request->has('type')) {
            $this->pushCriteria(new Criteria\EventTypeCriteria());
        }
        if ($request->has('date')) {
            $this->pushCriteria(new Criteria\EventDateCriteria());
        }
        if (strlen($request->get('start_date')) > 0 && strlen($request->get('start_date')) > 0) {
            $this->pushCriteria(new Criteria\EventDateRangeCriteria());
        }
        if ($request->has('city')) {
            $this->pushCriteria(new Criteria\EventCityCriteria());
        }

        return $this->with('user')->orderBy('created_at', 'desc')->all();
    }

    public function getEventsTypes(): array
    {
        return $this->eventTypes;
    }

    public function saveImage(Request $request, int $id)
    {
        if ($request->hasFile('file')) {
            $userId = $request->user()->id;
            $fileName = time() . '_' . $userId . '.' . $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs("public/{$userId}", $fileName);
            return $this->update(['image' => $fileName], $id);
        } else {
            return false;
        }
    }
}
