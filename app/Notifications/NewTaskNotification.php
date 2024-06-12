<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;

class NewTaskNotification extends Notification
{
    public $materialTitle;
    public $coachFirstName;
    public $coachLastName;
    public $sportName;
    public $sportId;

    public function __construct($materialTitle, $coachFirstName, $coachLastName, $sportName, $sportId) // Add $sportId parameter
    {
        $this->materialTitle = $materialTitle;
        $this->coachFirstName = $coachFirstName;
        $this->coachLastName = $coachLastName;
        $this->sportName = $sportName;
        $this->sportId = $sportId; 
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('A new task has been posted by Coach ' . $this->coachFirstName . ' ' . $this->coachLastName .  ' under ' . $this->sportName . '.')
            ->action('View Checklist', url('/class/' . $this->sportId)) // Use $this->sportId
            ->line('Thank you for using our application!');
    }
}
