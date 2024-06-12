<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EventNotification extends Notification
{
    public $eventTitle;
    public $coachFirstName;
    public $coachLastName;
    public $sportName;
    public $sportID;
    

    public function __construct( $eventTitle, $coachFirstName, $coachLastName, $sportName,$sportID)
    {
      
        $this->eventTitle = $eventTitle;
        $this->coachFirstName = $coachFirstName;
        $this->coachLastName = $coachLastName;
        $this->sportName = $sportName;
        $this->sportID = $sportID;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('A new task has been posted on the calendar by Coach ' . $this->coachFirstName . ' ' . $this->coachLastName . ' named  ' . $this->eventTitle . ' under ' . $this->sportName . '.')
            ->action('View Calendar', url('/calendar/' . $this->sportID))
            ->line('Thank you for using our application!');
    }
}
