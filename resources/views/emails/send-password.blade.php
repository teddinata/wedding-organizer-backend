<x-mail::message>
# Hello {{ $password->name }}, below is your credential to login:

{{-- container box email and password --}}
<div style="border: 1px solid #777070; padding: 10px; margin-bottom: 5px;">
    <p>Email: <b>{{ $password->email }}</b></p>
    <p>Password: <b>{{ $password->password }}</b></p>
</div>
<b>NOTE:</b>
<ul style="list-style-type: square; margin-left: 8pipx; margin-top: -2px">
    <li>Your password is <b>confidential</b>.</li>
    <li>Do not share this Password with anyone.</li>
    <li>You may change the password on dashboard later.</li>
</ul>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
