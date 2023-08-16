<x-mail::message>
# Hello {{ $otp->name }}, below is your credential to login:

{{-- container box email and otp --}}
<div style="border: 1px solid #777070; padding: 10px; margin-bottom: 5px;">
    <p>Email: <b>{{ $otp->email }}</b></p>
    <p>One Time Password: <b>{{ $otp->otp }}</b></p>
</div>
<b>NOTE:</b>
<ul style="list-style-type: square; margin-left: 8pipx; margin-top: -2px">
    <li>The OTP is valid for <b>15 minutes</b> only.</li>
    <li>Do not share this OTP with anyone.</li>
    <li>You may change the password on our mobile app later.</li>
</ul>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
