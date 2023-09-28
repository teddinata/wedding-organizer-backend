<x-mail::message>
<p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-bottom: 0; font-size: 20px; font-weight: 600;">Hey</p>
<p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-top: 0; font-size: 24px; font-weight: 700; color: #ff5850;">{{ $otp->name }}!</p>

<p>A request to change e-mail address was received from your <b>Goodsone</b> Account.</p>
<p>Use this otp to change your email.</p>

<x-mail::panel>
    <p>Email: <b>{{ $otp->email }}</b></p>
    <p>Verification code: <b>{{ $otp->otp }}</b></p>
</x-mail::panel>
<br>
<b>Note:</b>
<ul style="list-style-type: square; margin-left: 8pipx; margin-top: -2px">
    <li>The Verification Code is valid for <b>3 days</b> only.</li>
    <li>Do not share this Code with anyone.</li>
</ul>
<br>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
