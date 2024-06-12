<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notification;

class NotificationPanel extends Component
{
    public $notifications;

    protected $listeners = ['notificationUpdated' => 'refreshNotifications'];

    public function mount()
    {
        // Fetch notifications where the authenticated user is the receiver
        $this->notifications = Notification::where('receiver_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
    }

        public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->update(['is_read' => true]);
        }

        // Fetch and update the notifications immediately after marking as read
        $this->notifications = Notification::where('receiver_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        $this->dispatch('notificationUpdated');
    }

   public function deleteAllNotifications()
{
    // Delete all notifications for the authenticated user
    Notification::where('receiver_id', auth()->id())->delete();

    // Fetch the updated notifications immediately after deletion
    $this->notifications = Notification::where('receiver_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();

    $this->dispatch('notificationUpdated');
}

    public function render()
    {
        return view('livewire.notification-panel');
    }

    /*protected function refreshNotifications()
    {
        $this->notifications = Notification::where('receiver_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
    }*/
}
