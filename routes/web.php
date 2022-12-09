<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Mail\ForgotPasswordController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPaswordController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\SubscriberController;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Support\Facades\Route;

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

//Book
Route::get('/', function () {
    return redirect(route('homePage'));
});
Route::resource('forgot_password', ForgotPasswordController::class);
Route::resource('reset_password', ResetPaswordController::class);
Route::resource('login', LoginController::class);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::resource('register', RegisterController::class);
Route::post('check-email', [RegisterController::class, 'checkEmail'])->name('register.checkEmail');
Route::post('check-name', [BookController::class, 'checkNameBook'])->name('book.checkName');
Route::get('homePage', [BookController::class, 'homeList'])->name('homePage');
Route::get('language/{language}', [LanguageController::class,'index'])->name('language.index');

Route::group([
    'middleware' => ['user_role'],
//    'prefix' => ['user'],
], function () {
    Route::resource('user/book', BookController::class);
    Route::post('export', [BookController::class, 'export'])->name('bookExport');
    Route::get('product/{id}', [ProductController::class, 'bookDetail'])->name('product.detail');
    Route::resource('user/product', ProductController::class);
    Route::resource('user/card', CardController::class);
    Route::post('/addComment', [CommentController::class, 'handleAddComment'])->name('user.addComment');
    Route::post('/getComment', [CommentController::class, 'handleGetComment'])->name('user.getComment');



//    Route::get('language/{language}', [LanguageController::class,'index'])->name('language.index');
//    Route::get('/test', function () {
//        return view('admin.vi');
//    });
});

Route::resource('stripe', StripeController::class);
//Route::get('{any}', [LoginController::class, 'index']);
Route::get('/getSession', [StripeController::class,'getSession']);
Route::get('/cancel', function (){ return view('app');});
Route::get('/success', function (){ return view('app');});
//Mail






// company
Route::group([
    'middleware' => ['user_role'],
//    'prefix' => ['user']
], function () {
    Route::resource('company', CompanyController::class);

    Route::get('/test', function () {
        return view('admin.vi');
    });
});
// cart
Route::get('/lala', function () {
    return Cart::add('293ad', 'Product 1', 1, 9.99, 550);

});

Route::get('/cart', function () {
    return Cart::content();
});
//Route::get('/', [LoginController::class, 'index']);
