<x-mail::message>
<p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-bottom: 0; font-size: 20px; font-weight: 600;">Hey</p>
<p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-top: 0; font-size: 24px; font-weight: 700; color: #ff5850;">{{ $password->name }}!</p>

<p> Please use the credentials below to log in:  </p>

<x-mail::panel>
    <p>Email: <b>{{ $password->email }}</b></p>
    <p>Password: <b>{{ $password->password }}</b></p>
    <p>Link: <b>{{ config('app.url') }}</b></p>
</x-mail::panel>
<br>
<b>Note:</b>
<ul style="list-style-type: square; margin-left: 8pipx; margin-top: -2px">
    <li>Your password is <b>confidential</b>.</li>
    <li>Do not share this Password with anyone.</li>
    <li>You may change the password on dashboard later.</li>
</ul>
<br>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
