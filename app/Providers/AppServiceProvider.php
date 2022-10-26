<?php

namespace App\Providers;

use App\Repositories\Book\BookInterface;
use App\Repositories\Book\BookRepository;
use App\Repositories\Company\CompanyInterface;
use App\Repositories\Company\CompanyRepository;
use App\Repositories\Users\UsersInterface;
use App\Repositories\Users\UsersRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CompanyInterface::class, CompanyRepository::class);
        $this->app->bind(BookInterface::class, BookRepository::class);
        $this->app->bind(UsersInterface::class, UsersRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
