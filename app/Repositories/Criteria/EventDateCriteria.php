<?php

namespace App\Repositories\Criteria;

use App\Repositories\Contracts\EventRepository;
use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class EventDateCriteria.
 *
 * @package namespace App\Criteria;
 */
class EventDateCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param \Illuminate\Database\Eloquent\Builder $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        switch (request('date')) {
            case EventRepository::ANY_THING:
                // Do nothing
                break;

            case EventRepository::TODAY:
                $now = Carbon::now()->format('Y-m-d');
                $model->where('start_date', '<=', $now)
                    ->where('end_date', '>=', $now);
                break;

            case EventRepository::TOMORROW:
                $tomorrow = Carbon::now()->addDay()->format('Y-m-d');
                $model->where('start_date', '<=', $tomorrow)
                    ->where('end_date', '>=', $tomorrow);
                break;

            case EventRepository::THIS_WEEK:
                Carbon::setWeekStartsAt(Carbon::SATURDAY);
                Carbon::setWeekEndsAt(Carbon::FRIDAY);

                $weekStart = Carbon::now()->startOfWeek()->format('Y-m-d');
                $weekEnd = Carbon::now()->endOfWeek()->format('Y-m-d');

                $today = Carbon::now()->format('Y-m-d');
                $model->whereBetween('start_date', [$weekStart, $weekEnd])
                    ->where('end_date', '>=', $today);
                break;

            case EventRepository::THIS_MONTH:
                $monthStart = Carbon::now()->startOfMonth()->format('Y-m-d');
                $monthEnd = Carbon::now()->endOfMonth()->format('Y-m-d');
                $today = Carbon::now()->format('Y-m-d');
                $model->whereBetween('start_date', [$monthStart, $monthEnd])
                    ->where('end_date', '>=', $today);
                break;

            case EventRepository::THIS_YEAR:
                $yearStart = Carbon::now()->startOfYear()->format('Y-m-d');
                $yearEnd = Carbon::now()->endOfYear()->format('Y-m-d');
                $today = Carbon::now()->format('Y-m-d');
                $model->whereBetween('start_date', [$yearStart, $yearEnd])
                    ->where('end_date', '>=', $today);
                break;
        }
        return $model;
    }
}
