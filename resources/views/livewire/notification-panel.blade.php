<div style="max-width: 400px; margin: auto;">  
    <div style="max-height: 300px; overflow-y: auto;">
        <button style="float: right; color:red; border:white;" wire:click="deleteAllNotifications" title="Clear all" onclick="reloadComponent()"><i class="fa fa-trash"></i></button><br>
        @if($notifications->isEmpty())
            <h6>No notifications yet.</h6>
        @else
            <ul style="list-style-type: none; padding: 0;">
                @foreach($notifications as $notification)
                    <li wire:click="markAsRead({{ $notification->id }})" style="cursor: pointer; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 10px;">
                        <div style="width: 10px; height: 10px; border-radius: 50%; background-color: {{ $notification->is_read ? 'transparent' : 'red' }}; display: inline-block; margin-right: 5px;"></div>
                        <h6> <strong>
                        @if ($notification->sender->avatar)
                            <img class="rounded-circle" src="{{ asset($notification->sender->avatar) }}" alt="Sender" style="width: 20px; height: 30px;">
                        @else
                            <img class="rounded-circle" src="{{ asset('assets/img/runner.png') }}" alt="Sender Avatar" style="width: 30px; height: 30px;">
                        @endif  
                        {{ $notification->sender->fname }} {{ $notification->sender->lname }}</strong> {{ $notification->message }}
                        </h6>
                        @if($notification->created_at)
                            <h6>{{ $notification->created_at->diffForHumans() }}</h6>
                            @if(!$notification->is_read)
                                <button wire:click="markAsRead({{ $notification->id }})" style="background-color: transparent; border: none; color: black; font-weight: bold; text-decoration: underline; cursor: pointer;" onclick="reloadComponent()">Mark as Read</button>
                            @endif
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <script>
        function reloadComponent() {
            // Reload the Livewire component
            Livewire.dispatch('refreshCount');
            console.log('Component reloaded');
        }

        document.addEventListener('livewire:load', function () {
            Livewire.hook('message.sent', () => {
                setTimeout(() => {
                    reloadComponent();
                }, 1000); // Refresh every 2 seconds
            });
        });
    </script>
</div>
