<?php
// このコードは、Genre というモデルクラスを定義しています。このクラスは、データベースの genres テーブルに対応するモデルです。Genre モデルは、主にジャンル情報を管理し、他のテーブル（特に Shop）とのリレーションを設定しています。
namespace App\Models;

// HasFactory:
// このトレイトは、Laravelのモデルファクトリー機能を使用するために必要です。ファクトリーは、テストやデータシーディングの際にデータを簡単に生成するための仕組みです。
// Model:
// Model クラスは、LaravelのEloquent ORMを使用するための基底クラスです。これを継承することで、データベース操作を簡単に行うことができます。
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


// Genre クラスは、Model クラスを継承しており、これによりEloquent ORMを使用してデータベースとやり取りします。genres テーブルに対する操作が簡単に行えるようになります。
class Genre extends Model
{
    use HasFactory;

// $fillable:
// このプロパティは、Eloquent モデルに対して一括代入を許可する属性（カラム）を定義します。
// genre_name というフィールドが一括代入できるように設定されています。
    protected $fillable = ['genre_name,'];


// shopsメソッド：
// これは リレーションメソッド で、Genre と Shop の間に「1対多」の関係を定義しています。
// Genre は複数の Shop を持つことができるため、hasMany メソッドを使用してそのリレーションを示しています。
// このメソッドを使用することで、特定の Genre に関連する Shop モデルのデータを簡単に取得できます。
    public function shops()
    {
        return $this->hasMany(Shop::class);
    }
}

// まとめ
// この Genre モデルは、以下の機能を提供しています：

// $fillable プロパティ: genre_name を一括代入可能にしています。
// shops メソッド: Genre モデルと Shop モデルの間で「1対多」のリレーションを定義し、特定のジャンルに関連するショップ情報を簡単に取得できるようにしています。
// このクラスを使用することで、genres テーブルとその関連する shops テーブルのデータを簡単に操作できるようになります。
