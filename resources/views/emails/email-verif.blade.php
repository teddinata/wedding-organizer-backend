<x-mail::message>
# Hello {{ $otp->name }}, below is your verification code for change e-email:

{{-- container box email and otp --}}
<div style="border: 1px solid #777070; padding: 10px; margin-bottom: 5px;">
    <p>Email: <b>{{ $otp->email }}</b></p>
    <p>Verification code: <b>{{ $otp->otp }}</b></p>
</div>
<b>NOTE:</b>
<ul style="list-style-type: square; margin-left: 8pipx; margin-top: -2px">
    <li>The Verification Code is valid for <b>3 days</b> only.</li>
    <li>Do not share this Code with anyone.</li>
</ul>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
