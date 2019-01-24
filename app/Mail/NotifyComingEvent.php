<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyComingEvent extends Mailable
{
    use Queueable, SerializesModels;

    public $event;

    /**
     * Create a new message instance.
     *
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("notification-coming@falyat.com")
            ->subject('Remind with "' . $this->event->name . '" event')
            ->view('emails.en.coming-event', [
            'event' => $this->event
        ]);
    }
}
