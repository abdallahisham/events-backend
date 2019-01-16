<?php namespace App\Services;

use App\Repositories\Contracts\EventRepository;
use App\Repositories\Contracts\UserRepository;
use Carbon\Carbon;
use Mail;
use App\Mail\NotifyComingEvent;

/**
 * Class EventNotificationsService
 * @package App\Services
 * @service
 */
class EventNotificationsService
{
    protected $userRepository;
    protected $eventRepository;

    public function __construct(UserRepository $usersRepository, EventRepository $eventRepository)
    {
        $this->userRepository = $usersRepository;
        $this->eventRepository = $eventRepository;
    }

    /**
     * Send emails for tomorrow events attenders
     */
    public function notifyUsersWithTomorrowEvents()
    {
        logger()->info('Start sending emails...');
        $tomorrowDateString = Carbon::now()->addDay()->format('Y-m-d');
        $events = $this->eventRepository->with(['going'])
            ->findWhere(['start_date' => $tomorrowDateString]);
        foreach ($events as $event) {
            Mail::to($event->going->all())->send(new NotifyComingEvent($event));
        }
        logger()->info('Emails sent.');
    }

}
