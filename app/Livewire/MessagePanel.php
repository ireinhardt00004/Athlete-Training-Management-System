<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\ChMessage;

class MessagePanel extends Component
{   
        public function getMessageSent()
    {
        $user = auth()->user();
        $userID = $user->id;

        // Retrieve messages for the authenticated user with specified criteria
        $messages = ChMessage::where('to_id', $userID)
            ->where('seen', false)
            ->get();

        return $messages;
    }

    public function render()
{
    $messages = $this->getMessageSent(); // Get the messages
    return view('livewire.message-panel', ['messages' => $messages]);
}

}
