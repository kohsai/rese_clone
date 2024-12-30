<?php
// Shop モデルは、おそらく「店舗」や「ショップ」のデータを管理するためのもので、店舗に関する情報をデータベースに保存し、関連するデータとのやり取りを行います。
namespace App\Models;

// HasFactory:
// HasFactory トレイトを使うことで、Shop モデルに対してモデルファクトリーを使用できるようになります。これにより、テストやダミーデータの生成が容易になります。
// Model:
// Eloquent ORMの基底クラスです。Shop モデルはこれを継承しており、これによりデータベースとのやり取りが簡単に行えます。
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Shop extends Model
{
    use HasFactory;
    // $fillable:
    // このプロパティは一括代入（mass assignment）を許可するカラムを指定します。
    // name、image_url、area_id、genre_id、descriptionの5つのカラムが一括で設定可能となります。
    protected $fillable = [
        'name',
        'image_url',
        'area_id',
        'genre_id',
        'description',
    ];

// area() メソッド:
// このメソッドは、Shop モデルが Area モデルと1対多のリレーションを持つことを示しています。
// 具体的には、1つのショップは1つのエリア（Area）に属しているという意味です。belongsTo() メソッドを使うことで、Shop モデルから関連する Area モデルのデータを取得できます
    public function area()
    {
        return $this->belongsTo(Area::class);
    }


// genre() メソッド:
// Shop モデルが Genre モデルと1対多のリレーションを持つことを示します。
// つまり、1つのショップは1つのジャンル（Genre）に属しています。belongsTo() メソッドを使って、Shop モデルから関連する Genre モデルの情報を取得できます。
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }


// likes() メソッド:
// Shop モデルと Like モデルとの1対多のリレーションを定義しています。
// つまり、1つのショップには複数の「いいね（Like）」がある可能性があるという意味です。
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

// isFavoritedByUser() メソッド:
// このメソッドは、特定のユーザーがそのショップを「いいね」しているかどうかを確認します。
// 引数で渡された userId を基に、likes リレーションを使って、該当ユーザーの「いいね」が存在するかどうかをチェックします。
// exists() メソッドは、指定された条件に一致するレコードが存在するかどうかを確認します。true が返されると、そのユーザーがそのショップを「いいね」しているということになります。
    public function isFavoritedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

}

// まとめ
// Shop モデルは、店舗に関する情報を管理するためのモデルで、主に以下の特徴を持っています：

// $fillable: 店舗に関する情報（名前、画像URL、エリア、ジャンル、説明など）を一括代入で簡単にデータベースに保存できるようにします。
// リレーションメソッド:
// area() と genre() メソッドは、それぞれショップが属するエリアとジャンルを取得するためのリレーションを定義しています。
// likes() メソッドは、ショップが受けている「いいね」の情報を取得します。
// isFavoritedByUser() メソッドは、特定のユーザーがそのショップを「いいね」しているかを確認します。
// これらを組み合わせることで、ショップに関連する情報（エリアやジャンル、ユーザーの「いいね」など）を効率的に管理し、関連データを簡単に取得できるようになります。