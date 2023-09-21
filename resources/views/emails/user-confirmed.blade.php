<x-mail::message>
# Account Confirmed!

Hello {{$user->name}}, this is the admin of the site {{ config('app.name') }}. We are happy to inform you that your account has been confirmed.

<x-mail::button :url="$login_url">
You can login now by pressing the button
</x-mail::button>

Thanks,<br>
University of Mindanao 
</x-mail::message>
