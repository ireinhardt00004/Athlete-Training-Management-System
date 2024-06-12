<div style="max-width: 400px; margin: auto;">
    <div style="max-height: 300px; overflow-y: auto;">
        @if($messages->isEmpty())
            <h6 style="margin: 10px 0;">No unread messages yet.</h6>
        @else
            <ul style="list-style-type: none; padding: 0;">
                @foreach ($messages as $message)
                    @if ($message->sender)
                        <li style="margin-bottom: 10px; font-weight: bold; color: black;">
                            <div style="display: flex; align-items: center;">
                                <a href="/chats/{{ $message->from_id }}" style="text-decoration: none; color: inherit;">
                                    @if ($message->sender->avatar)
                                        <img class="rounded-circle" src="{{ asset($message->sender->avatar) }}" alt="Sender" style="width: 30px; height: 30px; margin-right: 10px;">
                                    @else
                                        <img class="rounded-circle" src="{{ asset('assets/img/runner.png') }}" alt="Sender Avatar" style="width: 30px; height: 30px; margin-right: 10px;">
                                    @endif  
                                    <h6 style="margin: 0;">
                                        @if ($message->attachment)
                                            {{ $message->sender->name }} sent an attachment
                                        @else
                                            {{ $message->sender->name }} sent a message
                                        @endif
                                    </h6>
                                </a><br>
                               
                            </div> <h6 >{{ $message->created_at->diffForHumans() }}</h6>
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif
    </div>
    <h5> <a class="dropdown-item text-center small text-black-500" style="font-weight: bold; display: block; text-align: center; margin-top: 10px; text-decoration: none; color: inherit;" href="/chats">Read More Messages</a></h5>
</div>
