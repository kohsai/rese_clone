<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class ReservationController extends Controller
{
    // 予約完了画面
    public function done()
    {
        return view('done');
    }

    public function store(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'date' => 'required|date',
            'time' => 'required',
            'number' => 'required|integer|min:1|max:20',
        ]);

        // ログインユーザーIDを追加し、start_at に日時を統合
        $reservationData = [
            'shop_id' => $validatedData['shop_id'],
            'user_id' => Auth::id(),
            'num_of_users' => $validatedData['number'],
            'start_at' => $validatedData['date'] . ' ' . $validatedData['time'],
        ];


        // データベースに予約を保存
        Reservation::create($reservationData);

        // セッションデータをクリア
        Session::forget('confirmationData');
        Session::forget('confirmationFlag');

        return redirect()->route('reservations.done')->with('message', '予約が完了しました！');
    }



    public function show($id)
    {
        // ショップ情報を取得
        $shop = Shop::with(['area', 'genre'])->findOrFail($id);

        // セッションから確認データを取得
        $confirmationData = Session::get('confirmationData', [
            'date' => '',
            'time' => '',
            'number' => '',
        ]);
        // confirmationFlagがセッションに保存されているか確認
        $confirmationFlag = Session::get('confirmationFlag', false);


        // セッションの確認データとフラグをビューに渡す
        return view('shops.show', compact('shop', 'confirmationData', 'confirmationFlag'));
    }



    // 確認ボタンの処理
    public function confirm(Request $request)
    {

        // バリデーション
        $validatedData = $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'date' => 'required|date',
            'time' => 'required',
            'number' => 'required|integer|min:1|max:20',
        ]);

        try {
            $shop = Shop::findOrFail($validatedData['shop_id']);

            // 確認データをセッションに保存
            $confirmationData = [
                'date' => $validatedData['date'],
                'time' => $validatedData['time'],
                'number' => $validatedData['number'],
                'shop_name' => $shop->name,
            ];

            // セッションに確認データを保存
            Session::put('confirmationData', $confirmationData);


            // 店舗詳細画面にリダイレクトし、確認情報を表示
            return redirect()->route('shops.show', ['id' => $shop->id])->with('confirmationFlag', true);
        } catch (\Exception $e) {
            \Log::error('Error in confirm method:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => '予約の確認に失敗しました。もう一度お試しください。']);
        }
    }

    //  選びなおすボタン
    public function resetForm($shopId)
    {
        // セッションから確認データを削除
        Session::forget('confirmationData');
        Session::forget('confirmationFlag');

        // 「選びなおす」ボタンが押された後、予約ページにリダイレクト
        return redirect()->route('shops.show', ['shop' => $shopId]);
    }

    // 予約削除メソッド
    public function destroy($id)
    {
        // ログインユーザーの予約を検索
        $reservation = Reservation::where('id', $id)
        ->where('user_id', auth()->id())  // ログインユーザーの予約のみ対象
        ->first();

        if ($reservation) {
            // 予約が見つかれば削除
            $reservation->delete();
            return redirect()->route('mypage')->with('success', '予約がキャンセルされました。');
        } else {
            return redirect()->route('mypage')->with('error', '予約のキャンセルに失敗しました。');
        }
    }


}