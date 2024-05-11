@foreach ($getChatUser as $user)
    <li class="clearfix active getChatWindows  @if (!empty($receiver_id)) @if ($receiver_id == $user['user_id'])
            active @endif
    @endif "
        id="{{ $user['user_id'] }}">

        {{-- <a class="clearfix active" href="{{ url('chat?receiver_id=' . $user['user_id']) }}"> --}}
        <img src="{{ $user['profile_pic'] }}" alt="avatar">
        <div class="about">
            <div class="name">{{ $user['name'] }}
                @if (!empty($user['messagecount']))
                    <span id="ClearMessage{{ $user['user_id'] }}"
                        style="background-color: red; border-radius: 50%; padding: 1px 6px; color: white; margin-left: 4px; ">{{ $user['messagecount'] }}</span>
                @endif
            </div>
            <div class="status">
                @if (!empty($user['is_online']))
                    <i class="fa fa-circle online"></i>
                    <span>Đang hoạt động</span>
                @else
                    <i class="fa fa-circle offline"></i>
                    {{ Carbon\Carbon::parse($user['updated_at'])->diffForHumans() }}
                @endif


            </div>
        </div>
        {{-- </a> --}}
    </li>
@endforeach
