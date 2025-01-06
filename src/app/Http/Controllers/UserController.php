<?php

namespace App\Http\Controllers;
use App\Models\Like;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Authファサードをインポート

class UserController extends Controller
{
    public function mypage(Request $request)
    {
        // ログインユーザーの情報を取得
        $user = Auth::user();

        // ユーザーのお気に入り店舗を取得
        $favorites = $user ? $user->favorites : []; // 必要に応じてリレーション設定を確認

        // ユーザーの予約情報を取得
        $reservations = $user ? $user->reservations : [];

        // 変更フォームを表示する予約ID
        $editReservationId = $request->edit_reservation;

        // 編集する予約が存在する場合、その情報を取得
        $editReservation = null;
        if ($editReservationId) {
            $editReservation = Reservation::find($editReservationId);
        }


        // ビューにデータを渡す
        return view('mypage', [
            'favorites' => $favorites,
            'reservations' => $reservations, // 予約情報もビューに渡す
            'editReservation' => $editReservation, // 編集対象の予約情報
        ]);
    }

    // 予約の更新処理
    public function updateReservation(Request $request, $id)
    {
        // 予約情報を取得
        $reservation = Reservation::findOrFail($id);

        // バリデーション
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'num_of_users' => 'required|integer|min:1',
        ]);

        // 予約情報を更新
        $reservation->start_at = $validated['date'] . ' ' . $validated['time']; // 予約日時
        $reservation->num_of_users = $validated['num_of_users']; // 予約人数
        $reservation->save();

        // 更新後はマイページにリダイレクト
        return redirect()->route('mypage')->with('success', '予約情報が更新されました。');
    }


}
