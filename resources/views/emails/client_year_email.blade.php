@component('mail::message')
# Hi {{ $client->name }}

It's been a greate to work with you.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ $client->user->name }}
@endcomponent
