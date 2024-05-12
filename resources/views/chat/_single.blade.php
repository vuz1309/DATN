@foreach ($getChat as $chat)
    @if ($chat->sender_id === Auth::user()->id)
        <li class="clearfix">
            <div class="message-data text-right">
                <span class="message-data-time">{{ Carbon\Carbon::parse($chat->created_date)->diffForHumans() }}</span>
                <img src="{{ $chat->getSender->getProfile() }}" alt="avatar">
            </div>
            <div class="message other-message float-right"> {!! $chat->message !!}

                @if (!empty($chat->file))
                    <div>
                        <a href="{{ $chat->getFile() }}" download="" target="_blank">Tải xuống</a>
                    </div>
                @endif

            </div>

        </li>
    @else
        <li class="clearfix">
            <div class="message-data"><img src="{{ $chat->getReceiver->getProfile() }}" alt="avatar">
                <span class="message-data-time">{{ Carbon\Carbon::parse($chat->created_date)->diffForHumans() }}</span>

            </div>
            <div class="message my-message "> {!! $chat->message !!}
                @if (!empty($chat->file))
                    <div>
                        <a href="{{ $chat->getFile() }}" download="" target="_blank">Tải xuống</a>
                    </div>
                @endif

            </div>
        </li>
    @endif
@endforeach
