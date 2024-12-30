<?php
// コード全体の目的
// 新規ユーザー登録機能を実装しています。
// ユーザーがフォームを通じて登録情報を送信し、データベースに保存します。
// 登録成功後に「感謝ページ（thanks）」へリダイレクトします。

namespace App\Http\Controllers;


// 使用するクラス:
// RegisterRequest: ユーザー入力をバリデーションするためのリクエストクラス。
// User: ユーザーデータを管理するモデル。
// Hash: パスワードをハッシュ化するためのクラス。
// Auth: ユーザー認証を管理するためのクラス。
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
   // ユーザー登録画面を表示する:
   public function register()
   {
      return view('register');
   }

   // 感謝ページを表示する
   public function thanks()
   {
      return view('thanks');
   }

   // ユーザー登録処理
   public function store(RegisterRequest $request)
   {
      // 入力データのバリデーション
// RegisterRequest を通じて、ユーザーが送信したデータを検証します。
// 検証ルールは RegisterRequest クラス内で定義されています。
// 検証成功後、検証済みのデータ ($validatedData) が返されます。
      $validatedData = $request->validated();

      // 新規ユーザーの作成
// ユーザー情報をデータベースに保存します。
// Hash::make: パスワードをハッシュ化して安全に保存します。
      $user = User::create([
         'name'  => $validatedData['name'],
         'email' => $validatedData['email'],
         'password' => Hash::make($validatedData['password']),
      ]);

      return redirect()->route('thanks');
   }
}

// 関連する機能やクラス
// 1. RegisterRequest クラス
// 役割:
// ユーザーが入力したデータをバリデーションします。
// 例:
// php
// public function rules()
// {
//     return [
//         'name' => 'required|string|max:255',
//         'email' => 'required|string|email|max:255|unique:users',
//         'password' => 'required|string|min:8|confirmed',
//     ];
// }
// 名前、メールアドレス、パスワードが正しい形式であることを検証します。
// メールアドレスがすでに使用されていないか (unique:users) も確認します。


// 2. ビュー (Bladeテンプレート)
// register.blade.php:
// ユーザーが名前、メールアドレス、パスワードを入力するフォームを表示します。
// thanks.blade.php:
// 登録成功後の感謝メッセージを表示します。
// まとめ


// このコントローラーは、以下の流れで新規ユーザー登録を処理します。

// 登録画面の表示 (register)
// ユーザーにフォームを提供。
// 登録処理 (store)
// 入力内容を検証。
// データベースに新しいユーザーを保存。
// パスワードをハッシュ化。
// 感謝ページの表示 (thanks)
// ユーザーに登録完了を通知。
// シンプルかつ安全な構造で、Laravelの機能を効果的に活用した設計です。