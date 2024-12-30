<?php
// このコードは、LaravelのEloquent ORMを使用してデータベースの**reservations**テーブルとやり取りを行うためのモデルクラスです。主に「予約」を管理するためのモデルであり、ユーザーがショップに対して予約を行う情報を保持します。
namespace App\Models;

// HasFactory:
// HasFactory トレイトを使うことで、テストデータを簡単に作成できるようになります。モデルファクトリーを使用するために必要なトレイトです。

// Model:
// Eloquent ORMの基底クラスで、Reservation はこれを継承することによって、reservations テーブルに対するデータ操作が簡単に行えます。

// Carbon:
// 日時操作を簡単に行うためのライブラリです。LaravelはデフォルトでCarbonをサポートしており、Carbonインスタンスとして日時を扱うことができます。

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;
// $fillable:
// このプロパティは、一括代入（mass assignment）を許可するカラムを指定します。これにより、モデルのインスタンスを作成する際に、一度に複数の属性を設定できます：
// shop_id, user_id, num_of_users, start_at という4つのカラムにデータを一括で挿入することができます。

    protected $fillable = [
        'shop_id',
        'user_id',
        'num_of_users',
        'start_at',
    ];

    // start_atをCarbonインスタンスとしてキャスト
// $casts:
// このプロパティは、モデルの属性が自動的にどのようにキャストされるかを定義します。ここでは、start_at 属性を datetime としてキャストしています。つまり、start_at の値は自動的に Carbon インスタンス に変換され、日付と時間を簡単に操作できるようになります。
    protected $casts = [
        'start_at' => 'datetime', // これによりstart_atが自動的にCarbonインスタンスに変換されます
    ];

// shop() メソッド:
// これは、Reservation モデルと Shop モデルとのリレーションを定義しています。
// Reservation は1つの Shop に関連しているため、Reservation モデルから shop メソッドを呼び出すと、関連する Shop モデルのデータを取得することができます。
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}

// まとめ
// Reservation モデルは、予約のデータを管理するためのモデルで、主に以下の特徴があります：

// $fillable: 予約に必要な属性（shop_id, user_id, num_of_users, start_at）を一括代入できるようにしています。
// $casts: start_at 属性を Carbon インスタンスとして自動的にキャストし、日時を簡単に扱えるようにしています。
// shop(): 予約がどのショップに関連しているかを示すリレーションメソッドを定義しており、Reservation と Shop の間に1対多のリレーションを作ります。
// このモデルを使用することで、ユーザーが予約したショップやその予約日時などのデータを簡単に管理できるようになります。