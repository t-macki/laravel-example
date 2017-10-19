@component('mail::message')
# 会員登録が完了しました。

The body of your message.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

{{$test}}
<br>
@component('mail::table')
| Laravel       | Table         | Example  |
| ------------- |:-------------:| --------:|
| Col 2 is      | Centered      | $10      |
| Col 3 is      | Right-Aligned | $20      |
@endcomponent
<br>

Thanks,<br>
{{ config('app.name') }}

@include('emails.footer')

@endcomponent
