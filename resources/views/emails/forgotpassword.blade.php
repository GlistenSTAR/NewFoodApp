@component('mail::message')
Hi {{$user->username}},

<p>Your Password : {{$password}}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent