<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ChMessage;

class UnseenMessagesCounter extends Component
{
    public $count;

    public function mount()
    {
        $this->count = $this->getUnseenMessagesCount();
    }

    public function render()
    {
        return view('livewire.unseen-messages-counter');
    }

   public function getUnseenMessagesCount()
{
    $user = auth()->user();
    $userID = $user->id;
    
    // Retrieve messages for the authenticated user
    $messages = ChMessage::where('to_id', $userID)->get();

    // Count the unseen messages
    return $messages->where('seen', false)->count();
}


    public function hydrate()
    {
        // Refresh the count every 5 seconds
        $this->count = $this->getUnseenMessagesCount();
        $this->dispatch('refreshCount');
    }
}
