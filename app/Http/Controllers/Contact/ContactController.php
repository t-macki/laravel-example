<?php

namespace App\Http\Controllers\Contact;

use App\Http\Requests\ContactRequest;
use App\Http\Controllers\Controller;
use App\Services\Contact\RegisterService;

class ContactController extends Controller
{
    /**
     * @var RegisterService
     */
    protected $contacts;

    /**
     * コンストラクタ
     *
     * @param RegisterService $contacts
     */
    public function __construct(RegisterService $contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contact.index');
    }

    public function create(ContactRequest $request)
    {
        return view('contact.confirm', ['data' => $request->attrs()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ContactRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        // 確認画面で戻るボタンが押された場合
        if ($request->get('action') === 'back') {
            // 入力画面へ戻る
            return redirect()
                ->route('get.contact.index')
                ->withInput($request->except(['action']));
        }

        $this->contacts->register($request->all());

        // ブラウザリロード等での二重送信防止
        $request->session()->regenerateToken();

        // 完了画面を表示
        return view('contact.thanks');
    }


}
