@component('mail::message')

Hi {{$name}},

We've received your message and let us thanks to you for contacting with us. Please find your information you have send.

##Name

{{$name}}

##Subject

{{$subject}}

## Message

{{$messages}}

Thanks,<br>
{{ get_option('site_name') }}
@endcomponent
