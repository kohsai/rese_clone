<?php
// このコードは、予約システムの予約管理を行う ReservationController というコントローラーで、ユーザーが店舗に予約をするためのロジックを提供しています。具体的には、予約の確認、完了、予約内容の変更などを扱っています。
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

    // store メソッド（予約を保存する）
    public function store(Request $request)
    {
// ユーザーがフォームで送信した予約内容をデータベースに保存します。

// バリデーション: 入力内容が正しいか（存在するショップID、日付、時間、人数の検証）を確認します。

        // バリデーション
        $validatedData = $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'date' => 'required|date',
            'time' => 'required',
            'number' => 'required|integer|min:1|max:20',
        ]);

        // 選択された日時が過去でないことを確認
        $selectedDateTime = Carbon::parse($validatedData['date'] . ' ' . $validatedData['time']);
        if ($selectedDateTime < Carbon::now()) {
            return back()->withErrors(['date' => '選択された日時は現在時刻より前です。']);
        }

        // 予約の競合チェック
        $isConflict = Reservation::where('shop_id', $validatedData['shop_id'])
        ->where('start_at', $selectedDateTime)
        ->exists();

        if ($isConflict) {
            return back()->withErrors(['date' => 'この日時ではすでに予約が埋まっています。他の日時を選択してください。']);
        }



// 予約情報にログインユーザーのID（Auth::id()）を追加し、start_at というフィールドに日時を統合して予約データを作成します。
        // ログインユーザーIDを追加し、start_at に日時を統合
        $reservationData = [
            'shop_id' => $validatedData['shop_id'],
            'user_id' => Auth::id(),
            'num_of_users' => $validatedData['number'],
            'start_at' => $validatedData['date'] . ' ' . $validatedData['time'],
        ];

// 予約が保存された後、セッションの確認データをクリアし、完了画面へリダイレクトします。
        // データベースに予約を保存
        Reservation::create($reservationData);

        // セッションデータをクリア
        Session::forget('confirmationData');
        Session::forget('confirmationFlag');

        return redirect()->route('reservations.done')->with('message', '予約が完了しました！');
    }


    // show メソッド（予約確認画面を表示）
    public function show($id)
    {
// 特定の店舗情報（Shop モデル）を取得し、その店舗の詳細ページを表示します。
        // ショップ情報を取得
        $shop = Shop::with(['area', 'genre'])->findOrFail($id);

// セッションから予約の確認データ（日時、人数、店舗名など）を取得してビューに渡します。
        // セッションから確認データを取得
        $confirmationData = Session::get('confirmationData', [
            'date' => '',
            'time' => '',
            'number' => '',
        ]);

// confirmationFlag を使って、ユーザーが予約内容を確認しているかどうかを判断します。
        // confirmationFlagがセッションに保存されているか確認
        $confirmationFlag = Session::get('confirmationFlag', false);


        // セッションの確認データとフラグをビューに渡す
        return view('shops.show', compact('shop', 'confirmationData', 'confirmationFlag'));
    }



    // confirm メソッド（予約内容の確認）
    public function confirm(Request $request)
    {

// ユーザーが予約内容を確認するために、確認データをセッションに保存し、店舗詳細ページにリダイレクトします。
        // バリデーション
        $validatedData = $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'date' => 'required|date',
            'time' => 'required',
            'number' => 'required|integer|min:1|max:20',
        ]);

        // 選択された日時が過去でないことを確認
        $selectedDateTime = Carbon::parse($validatedData['date'] . ' ' . $validatedData['time']);

        if ($selectedDateTime < Carbon::now()) {
            // エラーメッセージをセッションに保存
            Session::flash('error_message', '選択された日時は現在時刻より前です。選びなおしてください。');
            return redirect()->route('shops.show', ['shop' => $request->shop_id]);
        }

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

            // 予約内容（店舗ID、日時、人数）を確認した後、セッションに保存してその後の画面に渡します。

            // 店舗詳細画面にリダイレクトし、確認情報を表示
            return redirect()->route('shops.show', ['id' => $shop->id])->with('confirmationFlag', true);
        } catch (\Exception $e) {
            \Log::error('Error in confirm method:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => '予約の確認に失敗しました。もう一度お試しください。']);
        }
    }


    //  選びなおし
    public function resetForm($shopId)
    {
        // セッションから確認データを削除
        Session::forget('confirmationData');
        Session::forget('confirmationFlag');

        // 「選びなおす」ボタンが押された後、予約ページにリダイレクト
        return redirect()->route('shops.show', ['shop' => $shopId]);
    }

    // 予約キャンセル
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

    // 予約変更
    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'num_of_users' => 'required|integer|min:1',
        ]);

        // 該当の予約を取得
        $reservation = Reservation::findOrFail($id);

        // 予約情報を更新
        $reservation->start_at = $request->date . ' ' . $request->time;
        $reservation->num_of_users = $request->num_of_users;
        $reservation->save();

        // ユーザーにフィードバックを提供
        return redirect()->route('mypage')->with('status', '予約を変更しました！');
    }

}

// まとめ
// このコントローラーは、以下の機能を提供します：

// 予約確認画面の表示。
// ユーザーの入力をもとに予約内容をデータベースに保存。
// 予約確認のための確認ボタンや、選び直しボタンの処理。
// ユーザーが予約をキャンセルする機能。
// ユーザーが予約を行う際に、セッションを利用して確認・選び直し・キャンセルのフローを管理し、必要なデータを保存・表示する役割を果たしています。