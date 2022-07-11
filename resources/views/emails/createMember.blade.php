@component('mail::message')

{{--    {{$details['title']}}--}}
{{--    {{$details['body']}}--}}

    @component('mail::button', ['url' => $url])
        Verify Your Account
    @endcomponent

    Thank You.
    {{ config('app.name') }}
@endcomponent
