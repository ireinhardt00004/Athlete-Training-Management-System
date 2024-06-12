<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notification;

class NotificationBadge extends Component
{
     public $count;

    protected $listeners = ['refreshCount' => 'refreshCount'];

    public function mount()
    {
        $this->count = $this->getUnreadNotificationCount();
    }

    public function render()
    {
        return view('livewire.notification-badge');
    }

    public function refreshCount()
    {
        $this->count = $this->getUnreadNotificationCount();
    }

    protected function getUnreadNotificationCount()
    {
        return Notification::where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->count();
    }

    public function hydrate()
    {
        // Refresh the count every 4 seconds
        $this->count = $this->getUnreadNotificationCount();
        $this->dispatch('refreshCount');
        $this->dispatch('$refresh');
    }
    
}
