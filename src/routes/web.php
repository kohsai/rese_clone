<?php

use App\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\FavoriteController;
use GuzzleHttp\Promise\Create;
use Illuminate\Auth\Events\Authenticated;

Route::get('/',
[ShopController::class, 'index']);

Route::get('/shops/show',
[ShopController::class, 'show'])->name('shops.show');

Route::post('/shops/{shop}', [ShopController::class, 'show'])->name('shops.show');

Route::get('/shops/edit', [ShopController::class, 'edit']
)->name('shops.edit');

Route::get('/shops/create', [ShopController::class, 'create'])->name('shops.create');


Route::get('/register', [RegisteredUserController::class, 'register']);

Route::get('/thanks',
[RegisteredUserController::class, 'thanks'])->name('thanks');


Route::get('/mypage',
[UserController::class, 'mypage'])->name('mypage');

Route::get('/menu',
[AuthenticatedSessionController::class, 'menu'])->name('menu');

Route::get('/login',
[AuthenticatedSessionController::class, 'login'])->name('login');

Route::get('/notloggedin',
[AuthenticatedSessionController::class, 'notloggedin'])->name('notloggedin');


// 検索フォーム
Route::get('/shops/search', [ShopController::class, 'search'])->name('shops.search');


Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');


// ログアウトルートを追加
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');



Route::get('/reservations/done',
[ReservationController::class, 'done'])->name('reservations.done');


Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

Route::post('/reservations/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');

Route::post('/reservations/store', [ReservationController::class, 'store'])->name('reservations.store');

// 選びなおすボタン
Route::get('/shops/{shop}/reset', [ReservationController::class, 'resetForm'])->name('reservations.reset');

// 予約取り消し
Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');




Route::post('/shops/{shop}/toggle-favorite', [FavoriteController::class, 'toggle'])->name('shops.toggle-favorite');


Route::resource('shops', ShopController::class);

// Route::resource('shops', ShopController::class);
// と定義した場合、一般的に以下のURLで各ビューにアクセスすることができます。
// 一覧表示: localhost/shops
// 新規登録フォーム: localhost/shops/create
// 店舗詳細: localhost/shops/show
// 特定の店舗の詳細: localhost/shops/1（1の部分は店舗のIDに置き換える）
// 店舗の編集: localhost/shops/1/edit（1の部分は店舗のIDに置き換える）
