@component('mail::message')
<p>
Hi {{ $user->name }}.<br>
For set your new password click on the button below.
</p>

@component('mail::button', ['url' => $link])
Set new password
@endcomponent

@endcomponent