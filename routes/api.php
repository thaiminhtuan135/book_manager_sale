<?php

use App\Http\Controllers\Api\BookApiController;
use App\Http\Controllers\Api\YourController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
//Route::group(['middleware'=>'auth:api'],function (){
//    Route::post('/book/comments', CommentController::class)->name('book.comment');
//    Route::post('/comments', CommentController::class)->name('book.addComment');
//});
//Route::get('api/getBook', BookApiController::class);
//Route::get('getBook', YourController::class);
//Route::get('get', [YourController::class,'__tuandeptrai']);
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);
    Route::resource('book', BookApiController::class);
});
