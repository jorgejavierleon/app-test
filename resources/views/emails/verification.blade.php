@component('mail::message')
# Verify your email

To complete the subscription process, please verify this email

@component('mail::button', ['url' => $url])
Verify
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
