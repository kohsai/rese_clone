<?php
// コントローラー全体の役割
// このコントローラーは、ログイン、ログアウト、および認証関連のビュー（画面）を表示するための処理を管理しています。

namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    public function menu() {
// resources/views/menu.blade.php ファイルに対応するビューを表示します。
        return view('menu');
    }

    public function login() {
// resources/views/login.blade.php ファイルに対応するビューを表示します。
        return view('login');
    }

    public function notloggedin() {
// resources/views/notloggedin.blade.php ファイルに対応するビューを表示します。
        return view('notloggedin');
    }


    // ユーザーのログイン認証を行います。
    public function store(LoginRequest $request)
    {
        // 入力バリデーション:
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


// 認証処理：
// 入力されたメールアドレスとパスワードを元に認証を試みます。
// 成功した場合:
// ログイン状態となり、ユーザーを「メニュー画面」 (menu) にリダイレクト。
// intended:
// ユーザーが認証が必要なページへアクセスしていた場合、そのページに戻します。
        if (Auth::attempt($credentials)) {
            return redirect()->intended('menu');
        }

// 失敗時、エラーメッセージをセッションに格納して元のページへ戻ります。
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが間違っています。',
        ]);
    }

    // ユーザーをログアウトさせます。
    public function destroy(Request $request)
    {
        // 現在ログイン中のユーザーをログアウト。
        Auth::logout();

        // 現在のセッションを無効化して、安全性を確保。
        $request->session()->invalidate();

        // CSRFトークンを再生成してセキュリティを強化。
        $request->session()->regenerateToken();

        // ログアウト後、トップページ（ / ）へリダイレクト。
        return redirect('/');
    }

};

// まとめ
// このコントローラーの主要なポイントは以下です:

// ログイン:
// メールアドレスとパスワードの検証後、ログインを試みる。
// 成功したら指定された画面に遷移。
// ログアウト:
// ログアウト後、セッションを安全に破棄。
// ビュー管理:
// ログインや未ログイン時に適切な画面を表示。
// これらにより、認証フロー全体をシンプルに管理しています。