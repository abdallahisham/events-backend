<?php

namespace App\Console\Commands;

use App\Services\EventNotificationsService;
use Illuminate\Console\Command;

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

    private $notificationsService;

    /**
     * Create a new command instance.
     * @param $notificationsService EventNotificationsService
     */
    public function __construct(EventNotificationsService $notificationsService)
    {
        parent::__construct();
        $this->notificationsService = $notificationsService;
    }

    /**
     * Send emails to
     *
     */
    public function handle()
    {
        $this->notificationsService->notifyUsersWithTomorrowEvents();
    }
}
