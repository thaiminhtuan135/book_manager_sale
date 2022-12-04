<?php


namespace App\Providers;

use App\Repositories\Book\BookInterface;
use App\Repositories\Book\BookRepository;
use App\Repositories\Comment\CommentInterface;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Company\CompanyInterface;
use App\Repositories\Company\CompanyRepository;
use App\Repositories\Product\ProductInterface;
use App\Repositories\Product\ProductRepository;
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
        $this->app->register(\Illuminate\Mail\MailServiceProvider::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(CommentInterface::class, CommentRepository::class);


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
