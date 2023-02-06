@component('mail::message')
<p>
Hi {{ $user->name }}.<br>
Thank you for registering your details with us. We'll be in touch soon with all the information you need and answers to any questions you might have.
</p>

@component('mail::button', ['url' => $link])
Activate account
@endcomponent

@endcomponent