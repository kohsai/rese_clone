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

// Route::get('/') は、アプリケーションのルートURL（/）にアクセスがあったときに実行されるルートです。この場合、ShopController の index メソッドが実行されます。
Route::get('/',
[ShopController::class, 'index']);


// 店舗関連のルート

// GET /shops/show と POST /shops/{shop} は、ショップの詳細表示ページに関連するルートです。
Route::get('/shops/show',
[ShopController::class, 'show'])->name('shops.show');

Route::post('/shops/{shop}', [ShopController::class, 'show'])->name('shops.show');

// GET /shops/edit は、ショップの編集ページを表示するためのルート。
Route::get('/shops/edit', [ShopController::class, 'edit']
)->name('shops.edit');

// GET /shops/create は、ショップの新規作成ページを表示するためのルートです。
Route::get('/shops/create', [ShopController::class, 'create'])->name('shops.create');



// ユーザー登録関連

// GET /register は、ユーザーの登録フォームを表示するためのルート。
Route::get('/register', [RegisteredUserController::class, 'register']);

// GET /thanks は、ユーザー登録後に表示される感謝ページです。
Route::get('/thanks',
[RegisteredUserController::class, 'thanks'])->name('thanks');

// POST /register は、ユーザー登録の情報を受け取り、新規ユーザーを作成するルート。
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');



// ログイン・ログアウト関連

// GET /login は、ログインフォームを表示するルート。
Route::get('/login',
[AuthenticatedSessionController::class, 'login'])->name('login');


Route::get('/notloggedin',
[AuthenticatedSessionController::class, 'notloggedin'])->name('notloggedin');

// POST /login は、ユーザーがログインするためのルート。
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

// POST /logout は、ユーザーがログアウトするためのルート。
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


Route::get('/menu',
[AuthenticatedSessionController::class, 'menu'])->name('menu');


// マイページ

// GET /mypage は、ログイン後にユーザーが自身のマイページにアクセスするためのルートです。
Route::get('/mypage',
[UserController::class, 'mypage'])->name('mypage');



// 店舗検索関連

// GET /shops/search は、ショップを検索するフォームに関連するルートです。
Route::get('/shops/search', [ShopController::class, 'search'])->name('shops.search');


// 予約関連

// GET /reservations/done は、予約完了ページを表示するルート。
Route::get('/reservations/done',
[ReservationController::class, 'done'])->name('reservations.done');

// POST /reservations は、予約を新規に作成するためのルート。
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

// POST /reservations/confirm は、予約の確認を行うためのルート。
Route::post('/reservations/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');


Route::post('/reservations/store', [ReservationController::class, 'store'])->name('reservations.store');

// GET /shops/{shop}/reset は、ユーザーが予約をリセットするためのルート。
Route::get('/shops/{shop}/reset', [ReservationController::class, 'resetForm'])->name('reservations.reset');


// DELETE /reservations/{reservation} は、予約を削除するためのルート。
Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');


// お気に入り関連

// POST /shops/{shop}/toggle-favorite は、ショップの「お気に入り」を切り替えるためのルートです。
Route::post('/shops/{shop}/toggle-favorite', [FavoriteController::class, 'toggle'])->name('shops.toggle-favorite');



// リソースコントローラの使用

Route::resource('shops', ShopController::class);
// Route::resource は、リソースコントローラに基づくルートを自動的に設定します。このルートによって、以下のようなCRUD操作が自動的に設定されます：
// 一覧表示 (GET /shops)
// 新規作成フォーム (GET /shops/create)
// 詳細表示 (GET /shops/{shop})
// 編集フォーム (GET /shops/{shop}/edit)
// 保存 (POST /shops)
// 更新 (PUT /shops/{shop})
// 削除 (DELETE /shops/{shop})
// Route::resource を使うことで、手動で各メソッドを設定する必要がなくなります。


// 問題点と改善点
// POST /shops/show と GET /shops/show が両方設定されていますが、通常、POST メソッドを使う理由が不明です。詳細ページは通常 GET メソッドで表示するのが一般的です。

// 改善提案: POST メソッドを GET に変更することで、リソースがより適切に扱われます。例えば、詳細ページは GET /shops/{shop} のように、ショップのIDを指定して表示するべきです。
// Route::resource('shops', ShopController::class); を使っているため、/shops/show や /shops/edit のような個別のルートは冗長になります。リソースコントローラで必要なルートは自動的に設定されるため、これらのルートは省略できます。

// 改善提案: 不要な個別ルートを削除し、リソースルートに統一することでコードが簡潔になります。


// まとめ
// このコードは、アプリケーション内のさまざまなリソース（ユーザー、店舗、予約、お気に入りなど）に関連するルート設定を行っています。Laravelのルーティング機能を活用して、リソースごとの操作に必要なURLとコントローラのメソッドを設定しています。ただし、いくつかのルートが冗長または不適切なHTTPメソッドで設定されているため、適切なHTTPメソッドやリソースコントローラを活用して、コードの効率化が可能です。