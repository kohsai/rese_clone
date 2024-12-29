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
            'number' => 'required|integer|min:1|max:10',
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

        // デバッグ用ログ
        \Log::info('Session Data:', [
            'confirmationData' => Session::get('confirmationData'),
            'confirmationFlag' => Session::get('confirmationFlag'),
        ]);



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

            $confirmationData = [
                'date' => $validatedData['date'],
                'time' => $validatedData['time'],
                'number' => $validatedData['number'],
                'shop_name' => $shop->name,
            ];

            Session::put('confirmationData', $confirmationData);
            Session::put('confirmationFlag', true);

            return redirect()->route('shops.show', ['shop' => $validatedData['shop_id']]);
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



}