<?php namespace App\Services;

use App\Repositories\Contracts\EventRepository;
use App\Repositories\Contracts\UserRepository;

/**
 * Class EventBookingService
 * @package App\Services
 */
class EventBookingService
{
    protected $eventRepository;
    protected $userRepository;

    public function __construct(
        EventRepository $eventRepository,
        UserRepository $userRepository
    )
    {
        $this->eventRepository = $eventRepository;
        $this->userRepository = $userRepository;
    }

    public function bookEvent(int $eventId)
    {
        $user = $this->userRepository->authenticatedUser();
        $user->booking()->toggle($eventId);
    }

    public function bookedEvents(int $userId)
    {
        $user = $this->userRepository->find($userId);
        return $user->booking()->orderBy('created_at', 'desc')->get();
    }

    public function likeEvent(int $eventId)
    {
        $user = $this->userRepository->authenticatedUser();
        $user->favorites()->toggle($eventId);
    }

    public function likedEvents(int $userId)
    {
        $user = $this->userRepository->find($userId);
        return $user->favorites()->orderBy('created_at', 'desc')->get();
    }
}