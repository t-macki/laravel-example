<?php

namespace App\Http\Controllers\User\Auth;

use App\Exceptions\ServiceException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Services\User\Auth\RegisterService;

class RegisterController extends Controller
{
    use RegistersUsers;

    public $service;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RegisterService $service)
    {
        $this->middleware('guest');
        $this->service = $service;
    }

    /**
     * 会員登録フォーム
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('user.auth.register');
    }

    /**
     * 会員登録
     * @param \App\Http\Requests\User\Auth\Register $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function register(\App\Http\Requests\User\Auth\Register $request)
    {
        $inputs = $request->attrs();
        try {
            $this->service->register($inputs);
        } catch (ServiceException $e) {
            \Session::flash('error_message', $e->getMessage());
            return view('user.auth.register');
        }

        // ブラウザリロード等での二重送信防止
        $request->session()->regenerateToken();

        \Session::flash('success_message', trans('message.user_register_mail_success'));
        return view('user.auth.complate');
    }


    /**
     * メール認証
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getVerify($token)
    {
        \Session::flush();
        try {
            $user = $this->service->verify($token);

            \Session::flash('success_message', trans('message.user_register_verify_success'));
        } catch (ServiceException $e) {
            \Session::flash('error_message', $e->getMessage());
            return redirect(route('get.user.register'));
        }
        return redirect(route('user.home'));
    }
}
