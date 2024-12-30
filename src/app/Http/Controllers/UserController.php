<?php

namespace App\Http\Controllers;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Authファサードをインポート

class UserController extends Controller
{
    public function mypage()
    {
        // ログインユーザーの情報を取得
        $user = Auth::user();

        // ユーザーのお気に入り店舗を取得
        $favorites = $user ? $user->favorites : []; // 必要に応じてリレーション設定を確認

        // ユーザーの予約情報を取得
        $reservations = $user ? $user->reservations : [];


        // ビューにデータを渡す
        return view('mypage', [
            'favorites' => $favorites,
            'reservations' => $reservations, // 予約情報もビューに渡す
        ]);
    }
}
