<?php
// このコードは、User モデルを定義しており、ユーザーに関する情報をデータベースに管理するために使用されます。Laravelの認証機能やリレーションなどを活用して、ユーザーの管理や関連データの取得を効率的に行います。
namespace App\Models;

// Authenticatable: Laravelの認証システムを使用するために、User クラスは Authenticatable クラスを継承します。これにより、ユーザーの認証やログインに関連する機能を利用できるようになります。

// HasFactory: ファクトリ機能を使用できるようにするために、HasFactory トレイトが使用されています。これにより、テストデータやダミーデータを簡単に生成できます。

// Notifiable: 通知機能を有効にするために Notifiable トレイトが使用されています。これにより、メールやSMSなどの通知を送る機能を活用できます。

// HasApiTokens: Laravel Sanctumを利用したAPI認証を有効にするために HasApiTokens トレイトを使用しています。これにより、APIトークンを用いた認証機能が使えるようになります。
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    //  $fillable: これは、一括代入（mass assignment） を許可する属性を定義しています。User モデルを作成するときに、name、email、password の3つの属性を一度に設定できます。
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */


     // $hidden: このプロパティは、ユーザーがデータをシリアライズ（配列やJSON形式に変換）する際に隠す属性を指定します。例えば、ユーザーのパスワードやリメンバートークンはセキュリティ上、シリアライズされる際に隠したい情報です。これにより、APIレスポンスやデータを出力する際に不必要な情報が含まれません。
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */


     // $casts: 属性を特定のデータ型に変換するための設定です。この例では、email_verified_at 属性が日時（datetime）としてキャストされるように設定されています。これにより、email_verified_at がデータベースから取得される際に、Carbon インスタンスに自動的に変換され、日時操作を簡単に行うことができます。
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ユーザーのお気に入り店舗とのリレーション
// favorites() メソッド:
// これはユーザーとショップとの間に多対多（many-to-many） のリレーションを定義しています。ユーザーが「お気に入り」を登録するために、likes という中間テーブルを使用しています。
// belongsToMany メソッドを使って、ユーザーが「お気に入りにした」ショップを取得できます。
    public function favorites()
    {
        return $this->belongsToMany(Shop::class, 'likes', 'user_id', 'shop_id');
    }


    // ユーザーが行った予約とのリレーション
// reservations() メソッド:
// これはユーザーと予約（Reservation）との間に1対多（one-to-many） のリレーションを定義しています。ユーザーは複数の予約を持つことができます。
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

}

// まとめ
// この User モデルは、ユーザーに関する情報を管理するために使用されます。主な特徴としては：

// $fillable: ユーザーの名前、メール、パスワードを一括代入で設定できるようにしています。
// $hidden: パスワードやトークンなど、シリアライズ時に隠したい属性を指定しています。
// $casts: email_verified_at を datetime 型として扱う設定がされています。
// リレーションメソッド:
// favorites(): ユーザーのお気に入りショップを取得するための多対多のリレーション。
// reservations(): ユーザーが行った予約を取得するための1対多のリレーション。
// これにより、ユーザーの認証情報や関連するデータ（お気に入りの店舗、予約）を簡単に管理できるようになります。