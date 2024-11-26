<?php

use App\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ShopController;
use GuzzleHttp\Promise\Create;

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

// Route::get('/', function () {
//     return view('welcome');
// });



Route::get('/',
[ShopController::class, 'index']);

Route::get('/register', [RegisteredUserController::class, 'create']);

Route::get('/thanks',
[RegisteredUserController::class, 'thanks']);


Route::get('/mypage',
[UserController::class, 'mypage']);

Route::get('/menu',
[AuthenticatedSessionController::class, 'menu']);

Route::get('/login',
[AuthenticatedSessionController::class, 'login'])->name('login');

Route::get('/notloggedin',
[AuthenticatedSessionController::class, 'notloggedin']);

Route::get('/done',
[ReservationController::class, 'done']);



Route::post('/shops', [ShopController::class, 'store'])->name('shops.store');

Route::resource('shops', ShopController::class);

// Route::resource('shops', ShopController::class);
// と定義した場合、一般的に以下のURLで各ビューにアクセスすることができます。
// 一覧表示: localhost/shops
// 新規登録フォーム: localhost/shops/create
// 店舗詳細: localhost/shops/detail
// 特定の店舗の詳細: localhost/shops/1（1の部分は店舗のIDに置き換える）
// 店舗の編集: localhost/shops/1/edit（1の部分は店舗のIDに置き換える）
