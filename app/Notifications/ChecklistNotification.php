<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Checklist;
use App\Models\User; // Assuming the User model is imported

class ChecklistNotification extends Notification
{
     public $checklist;
    public $materialTitle;
    public $coachFirstName;
    public $coachLastName;
    public $sportName;

    public function __construct($checklist, $materialTitle, $coachFirstName, $coachLastName, $sportName)
    {
        $this->checklist = $checklist;
        $this->materialTitle = $materialTitle;
        $this->coachFirstName = $coachFirstName;
        $this->coachLastName = $coachLastName;
        $this->sportName = $sportName;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('A new checklist form has been created by Coach ' . $this->coachFirstName . ' ' . $this->coachLastName . ' for ' . $this->materialTitle . ' under ' . $this->sportName . '.')
            ->action('View Checklist', url('/checklist-fetch/' . $this->checklist->id))
            ->line('Thank you for using our application!');
    }
}
