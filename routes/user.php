<?php
Route::group(['middleware' => 'guest:users'], function () {

    Route::get('login', 'Auth\LoginController@showLoginForm')->name('get.user.login');
    Route::post('login', 'Auth\LoginController@login')->name('post.user.login');

    Route::get('login/facebook', 'Auth\LoginController@redirectToProvider')->name('get.facebook.login');
    Route::get('facebook/callback', 'Auth\LoginController@handleProviderCallback');
    Route::get('callback', 'Auth\LoginController@handleProviderCallback');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('get.user.register');
    Route::post('register', 'Auth\RegisterController@register')->name('post.user.register');
    Route::get('verify/{token}', 'Auth\RegisterController@getVerify')->name('get.user.verify');

    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('get.user.password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('post.user.password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('get.user.password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('post.user.password.reset');
});

Route:: group(['middleware' => 'auth:users'], function () {
    Route::post('logout', 'Auth\LoginController@logout')->name('user.logout');
    Route::get('home', 'HomeController@index')->name('user.home');
    Route::get('/', 'HomeController@index')->name('user.home');
});
