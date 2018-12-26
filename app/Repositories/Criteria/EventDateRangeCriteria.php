<?php

namespace App\Repositories\Criteria;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class EventDateRangeCriteria.
 *
 * @package namespace App\Criteria;
 */
class EventDateRangeCriteria implements CriteriaInterface
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
        $startDate = (new Carbon(request('start_date')))->format('Y-m-d');
        $endDate = (new Carbon(request('end_date')))->format('Y-m-d');
        $model->whereBetween('start_date', [$startDate, $endDate]);
        return $model;
    }
}
