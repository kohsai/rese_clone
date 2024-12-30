<?php
// 全体の役割
// お気に入り登録や解除の処理を管理します。
// ユーザーがログインしている場合のみ、お気に入り操作を行えます。
// 未ログインの場合は、ログインページに誘導します。

namespace App\Http\Controllers;

// 使用するクラス:
// Shop: お気に入り対象となる店舗のモデル。
// Request: HTTPリクエストデータを操作するためのクラス。
// Auth: 認証関連の処理をサポートするクラス。

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// コンストラクタでのミドルウェア設定
class FavoriteController extends Controller
{
    // ミドルウェアで認証
    public function __construct()
    {
// auth ミドルウェアを適用。
// only('toggle'):  toggle メソッドにのみ適用されます。
// このミドルウェアにより、ログインしていないユーザーは toggle メソッドを実行できなくなります。
        $this->middleware('auth')->only('toggle');
    }


    // お気に入り登録・解除
    public function toggle(Shop $shop)
    {
    // ログインチェック：ユーザーがログインしているかを確認します。
        if (Auth::check()) {

    // お気に入りのトグル処理：現在のユーザーがこのショップをお気に入り登録しているかを確認します。
        if ($shop->isFavoritedByUser(auth()->id())) {

    // ユーザーIDを条件に、お気に入りデータを削除します。
            $shop->likes()->where('user_id', auth()->id())->delete();
        } else {

    // 新しいお気に入りデータを作成します。登録にはユーザーIDを付加します。
            $shop->likes()->create(['user_id' => auth()->id()]);
        }
        // リダイレクト処理：
        return redirect()->back();
        } else {
            // 未ログインの場合はログインページにリダイレクト
            return redirect()->back;
        }
    }
}


// 関連するモデルの役割
// このコードは Shop モデルの以下のようなメソッドやリレーションを前提に動作しています。

// isFavoritedByUser メソッド:
// 役割: 指定したユーザーが店舗をお気に入りに登録しているかを判定します。
// 実装例:

// php
// public function isFavoritedByUser($userId)
// {
//     return $this->likes()->where('user_id', $userId)->exists();
// }


// likes リレーション:
// 役割: 店舗が持つお気に入りデータを取得します。
// 実装例:
// php
// public function likes()
// {
//     return $this->hasMany(Favorite::class);
// }

// まとめ
// このコントローラーは、シンプルにお気に入り機能を実現しています。

// ログイン状態の確認: ミドルウェアと Auth::check() を利用。
// お気に入りの登録・解除: isFavoritedByUser メソッドで判定し、トグル動作。
// ユーザー体験: 操作後、元のページに戻ることでスムーズなUXを実現。
// 注意点: 未ログイン時のリダイレクト処理は、ログインページへの誘導がより適切です。