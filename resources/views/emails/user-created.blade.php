<x-mail::message>
# Account Created!

Hello {{$user->name}}, this is the admin of the site {{ config('app.name') }}. We are happy to inform you that we created your account.
You can use this temporary password <b>{{$password}}</b> at the moment and change it later.

<x-mail::button :url="$login_url">
You can login now by pressing the button
</x-mail::button>

Thanks,<br>
University of Mindanao 
</x-mail::message>
