<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // ミドルウェアで認証
    public function __construct()
    {
        $this->middleware('auth')->only('toggle');
    }

    // お気に入り登録・解除
    public function toggle(Shop $shop)
    {
        if (Auth::check()) {
            // ログインしている場合はお気に入りをトグル

        if ($shop->isFavoritedByUser(auth()->id())) {
            // お気に入り解除
            $shop->likes()->where('user_id', auth()->id())->delete();
        } else {
            // お気に入り登録
            $shop->likes()->create(['user_id' => auth()->id()]);
        }
        return redirect()->back();
        } else {
            // 未ログインの場合はログインページにリダイレクト
            return redirect()->back;
        }
    }
}
