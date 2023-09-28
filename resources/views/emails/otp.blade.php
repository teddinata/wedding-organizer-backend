<x-mail::message>
<p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-bottom: 0; font-size: 20px; font-weight: 600;">Hey</p>
<p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-top: 0; font-size: 24px; font-weight: 700; color: #ff5850;">{{ $otp->name }}!</p>

<x-mail::panel>
    <p>Email: <b>{{ $otp->email }}</b></p>
    <p>One Time Password: <b>{{ $otp->otp }}</b></p>
</x-mail::panel>
<br>
<b>Note:</b>
<ul style="list-style-type: square; margin-left: 8pipx; margin-top: -2px">
    <li>The OTP is valid for <b>15 minutes</b> only.</li>
    <li>Do not share this OTP with anyone.</li>
    <li>You may change the password on our mobile app later.</li>
</ul>
<br>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
