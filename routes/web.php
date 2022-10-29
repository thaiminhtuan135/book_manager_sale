<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
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

Route::get('/', function () {
    return redirect(route('login.index'));
});
Route::resource('login', LoginController::class);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::resource('register', RegisterController::class);
Route::post('check-email', [RegisterController::class, 'checkEmail'])->name('register.checkEmail');

Route::group([
    'middleware' => ['user_role'],
//    'prefix' => ['user']
], function () {
    Route::resource('company', CompanyController::class);

    Route::get('/test', function () {
        return view('admin.vi');
    });
});


Route::get('homePage', [BookController::class, 'homeList'])->name('homePage');
Route::group([
    'middleware' => ['user_role'],
//    'prefix' => ['user'],
], function () {
    Route::resource('user/book', BookController::class);

//    Route::get('/test', function () {
//        return view('admin.vi');
//    });
});



