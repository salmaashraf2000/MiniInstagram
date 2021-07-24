@component('mail::message')
# Welcome to our website MiniIntagram

We are happy that you havee decided to join us, we hope you enjoy.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
