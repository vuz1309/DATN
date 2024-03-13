@component('mail::message')
Xin chào {{$user->name}}!
<p>Chúng tôi gửi bạn đường dẫn để làm mới lại mật khẩu.</p>

@component('mail::button', ['url' => url('reset/' . $user->remember_token)])
Làm mới mật khẩu
    
@endcomponent

<p>Trong trường hợp bạn gặp bất kì vấn đề gì, hãy liên hệ với chúng tôi qua email này.</p>
{{config('app_name')}}
    
@endcomponent