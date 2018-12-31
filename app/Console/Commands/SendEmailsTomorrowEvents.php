<?php

namespace App\Console\Commands;

use App\Mail\NotifyComingEvent;
use App\Repositories\Contracts\EventRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Mail;

class SendEmailsTomorrowEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-coming';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Sending emails to tomorrow's events going users";

    private $eventRepository;

    /**
     * Create a new command instance.
     * @param EventRepository $eventRepository
     */
    public function __construct(EventRepository $eventRepository)
    {
        parent::__construct();
        $this->eventRepository = $eventRepository;
    }

    /**
     * Send emails to
     *
     */
    public function handle()
    {
        logger()->info('Sending emails...');
        $comingEvents = $this->eventRepository->with('going')
            ->findWhere(['start_date' => Carbon::now()->addDay()->format('Y-m-d')]);
        foreach ($comingEvents as $event) {
            Mail::to($event->going->all())->send(new NotifyComingEvent($event));
        }
        logger()->info('Emails sent.');
    }
}
