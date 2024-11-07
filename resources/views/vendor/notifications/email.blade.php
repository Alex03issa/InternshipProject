@component('mail::message')

{{-- Logo --}}
<img src="{{ asset('images/logo.png') }}" alt="Side to Side Logo" style="width: 150px; margin: 0 auto; display: block;">

# Hello!

You are receiving this email because we received a password reset request for your account.

@component('mail::button', ['url' => $actionUrl])
Reset Password
@endcomponent

This password reset link will expire in 60 minutes.

If you did not request a password reset, no further action is required.

Regards,  
Side to Side

---

If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:  
[{{ $actionUrl }}]({{ $actionUrl }})

If you have any issues, feel free to [contact us](mailto:majed.issa62@gmail.com).

@endcomponent
