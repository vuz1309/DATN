@component('mail::message')
    Xin chào {{ $user->name }}!
    <h3>{{ $user->send_subject }}</h3>
    <p>{!! $user->send_message !!}</p>
    <br />
    {{ config('app_name') }}
@endcomponent
