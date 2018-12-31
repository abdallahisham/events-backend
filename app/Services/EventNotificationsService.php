<?php namespace App\Services;

use App\Repositories\Contracts\EventRepository;
use App\Repositories\Contracts\UsersRepository;
use Carbon\Carbon;

/**
 * Class EventNotificationsService
 * @package App\Services
 * @service
 */
class EventNotificationsService
{
    private $userRepository;
    private $eventRepository;

    public function __construct(UsersRepository $usersRepository, EventRepository $eventRepository)
    {
        $this->userRepository = $usersRepository;
        $this->eventRepository = $eventRepository;
    }

    public function notifyUsersWithTomorrowEvents()
    {
        $tomorrowDateString = Carbon::now()->addDay()->format('Y-m-d');
        $events = $this->eventRepository->with(['going'])
            ->findWhere(['start_date' => $tomorrowDateString]);
        return $events;
    }

}