@component('mail::message')
# New Message from {{ $data['email']}}

<strong>Hi Janu, </strong>
<p>
{{ $data['message'] }}
</p>

<p><strong>Email</strong>:{{ $data['email']}}</p>

Regards,<br>
{{ $data['name']}}
@endcomponent
