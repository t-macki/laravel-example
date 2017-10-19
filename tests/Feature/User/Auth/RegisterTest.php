<?php

namespace Tests\Feature\User\Auth;

use Carbon\Carbon;
use Domain\Services\Shared\TokenService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Infra\Eloquents\User;
use Infra\Mail\User\UserRegister;
use Infra\Mail\User\UserVerify;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * 会員登録フォーム
     */
    public function testRegisterFormSuccess()
    {
        $response = $this->get(route('get.user.register'));
        $response->assertStatus(200);
        $response->assertViewIs('user.auth.register');
    }

    /**
     * 会員登録
     */
    public function testRegisterSuccess()
    {
        // メール送信防止
        Mail::fake();

        $inputs = [
            'email'                 => 'beyond.prep@gmail.com',
            'password'              => '11111111',
            'password_confirmation' => '11111111',
        ];

        $response = $this->post(route('post.user.register'), $inputs);
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', ['email_temp' => $inputs['email']]);
        $response->assertSessionMissing('errors');

        Mail::assertSent(UserRegister::class, function ($mail) use ($inputs) {
            return $mail->hasTo($inputs['email']);
        });

        $response->assertViewIs('user.auth.complate');
    }

    /**
     * メール認証
     */
    public function testVerifySuccess()
    {
        // メール送信防止
        Mail::fake();

        $verifyData = new Carbon();
        $user = factory(\Infra\Eloquents\User::class)->create([
            'email'                => 'usertestverifysuccess@example.com_temp',
            'email_temp'           => 'usertestverifysuccess@example.com',
            'email_verify_time'    => null,
            'email_verify_sent_at' => $verifyData,
            'email_verify_status'  => \Config::get('const.USER_VERIFY_STATUS_NG'),
        ]);

        $this->get(route('get.user.verify', $user->email_verify_token));

        $update = User::find($user->id);
        $this->assertEquals(\Config::get('const.USER_VERIFY_STATUS_OK'), $update->email_verify_status);

        Mail::assertSent(UserVerify::class, function ($mail) use ($update) {
            return $mail->hasTo($update->email);
        });
    }

    /**
     * メール認証エラー
     * 他のパターンはServiceでテスト
     */
    public function testVerifyFail()
    {
        // 期限切れ
        $verifyData = new Carbon();
        $verifyData->subDay(8);
        $user = factory(User::class)->create([
            'email'                => 'usertestverifyfail@example.com',
            'email_verify_time'    => null,
            'email_verify_sent_at' => $verifyData,
            'email_verify_status'  => \Config::get('const.USER_VERIFY_STATUS_NG'),
        ]);

        $response = $this->get(route('get.user.verify', $user->email_verify_token));

        $update = User::find($user->id);
        $this->assertEquals(\Config::get('const.USER_VERIFY_STATUS_NG'), $update->email_verify_status);
        $response->assertSessionHas('error_message');
    }


    /**
     * バリデーションテスト
     */
    public function testRegisterValidateFail()
    {
        // 必須
        $response = $this->post(route('post.user.register'), [
            'email' => '',
        ]);

        $response->assertSessionHas('errors');
        $response->assertSessionHasErrors([
            'email' => trans('validation.required', ['attribute' => trans('validation.attributes.email')])
        ]);
        Session::forget('errors');

        // 文字列
        $response = $this->post(route('post.user.register'), [
            'email' => 123,
        ]);
        $response->assertSessionHas('errors');
        $response->assertSessionHasErrors([
            'email' => trans('validation.string', ['attribute' => trans('validation.attributes.email')])
        ]);
        Session::forget('errors');

        // メール形式
        $response = $this->post(route('post.user.register'), [
            'email' => 'testmail@12345',
        ]);
        $response->assertSessionHas('errors');
        $response->assertSessionHasErrors([
            'email' => trans('validation.email', ['attribute' => trans('validation.attributes.email')])
        ]);
        Session::forget('errors');

        // 最大
        $response = $this->post(route('post.user.register'), [
            'email' => 'usertestregistervalidatefail' . str_random(255) . '@alleyoop.jp',
        ]);
        $response->assertSessionHas('errors');
        $response->assertSessionHasErrors([
            'email' => trans('validation.max.string',
                ['attribute' => trans('validation.attributes.email'), 'max' => 255]
            )
        ]);
        Session::forget('errors');

        // メール登録済み
        factory(User::class)->create(['email' => 'userregistervalidatefailtest@example.com']);
        $response = $this->post(route('post.user.register'), [
            'email' => 'userregistervalidatefailtest@example.com',
        ]);
        $response->assertSessionHas('errors');
        $response->assertSessionHasErrors([
            'email' => trans('validation.unique', ['attribute' => trans('validation.attributes.email')])
        ]);
        Session::forget('errors');
    }
}
