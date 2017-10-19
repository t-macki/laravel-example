<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/verifymail', function(){
    // routeから作成したメールクラスを呼び出してメールを確認
    return new Infra\Mail\User\UserVerify(new \Domain\Entity\User());
});