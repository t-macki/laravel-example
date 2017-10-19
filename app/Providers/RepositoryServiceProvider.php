<?php

namespace App\Providers;

use App\Infrastructure\Eloquents\Product;
use App\Infrastructure\Repositories\User\UploadRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Domain\Interfaces\Repositories\UserRepository::class,
            \Infra\Repositories\Eloquents\EloquentUserRepository::class
        );

        $this->app->bind(
            \Domain\Interfaces\Notifications\UserRegisterNotification::class,
            \Infra\Repositories\Mail\MailUserRegisterNotification::class
        );
        $this->app->bind(
            \Domain\Interfaces\Notifications\UserVerifyNotification::class,
            \Infra\Repositories\Mail\MailUserVerifyNotification::class
        );
    }
}
