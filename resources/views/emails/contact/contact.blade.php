@component('mail::message')
# お問い合わせが完了しました。

{{ $contact->name }}さん、お問い合わせありがとうございます。

お問い合わせ内容
<br>
件名：{{ $contact->subject }}
<br>
内容：
{{ $contact->content }}
<br>

Thanks,<br>
{{ config('app.name') }}

@include('emails.footer')

@endcomponent
