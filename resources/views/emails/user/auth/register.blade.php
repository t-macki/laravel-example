当システムをご利用いただくにあたり、メールアドレスの確認をしております。<br>
<br>
下記URLより会員登録をお願い致します。<br>
<a href="{{ url('user/verify', [$user->email_verify_token]) }}">{{ url('user/verify', [$user->email_verify_token]) }}</a><br>
<br>
@include('emails.footer')
