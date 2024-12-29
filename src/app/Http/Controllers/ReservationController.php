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
        // ショップ情報を取得し、リレーションもロード
        $shop = Shop::with(['area', 'genre'])->findOrFail($id);

        // セッションから確認データを取得
        $confirmationData = Session::get('confirmationData', [
            'date' => '',
            'time' => '',
            'number' => '',
        ]);
        $confirmationFlag = Session::get('confirmationFlag', false);


        // ビューにデータを渡す
        return view('shops.show', [
            'shop' => $shop,
            'confirmationData' => $confirmationData ?? [], // 必要に応じて空の配列をデフォルトに設定
        ]);
    }

    // 確認ボタンの処理
    public function confirm(Request $request)
    {
        // 入力値を取得
        $validatedData = $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'date' => 'required|date',
            'time' => 'required',
            'number' => 'required|integer|min:1|max:10',
        ]);

        // 日付と時間のフォーマット
            $formattedDate = Carbon::parse($validatedData['date'])->format('Y年m月d日');
            $formattedTime = $validatedData['time'];

         // 確認データをセッションに保存
            $confirmationData = [
                'date' => $formattedDate,
                'time' => $formattedTime,
                'number' => $validatedData['number'],
            ];
        Session::put('confirmationData', $confirmationData);
        Session::put('confirmationFlag', true);

        // ショップ情報取得
        $shop = Shop::findOrFail($validatedData['shop_id']);

        // ビューにデータを渡す
        return redirect()->route('shops.show', $validatedData['shop_id']);

    }
}