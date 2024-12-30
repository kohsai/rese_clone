<?php
// このコードは、Area というモデルクラスを定義しています。このクラスは、データベースの areas テーブルに対応するモデルです。Area モデルは、主にエリア情報を管理し、他のテーブル（特に Shop）とのリレーションを設定しています。

namespace App\Models;

// HasFactory:
// このクラスでファクトリーを使用するためのトレイトです。ファクトリーはテストデータを簡単に生成するために使われます。
// Model:
// Model クラスは、LaravelのEloquent ORM（オブジェクトリレーショナルマッピング）を提供する基本クラスです。このクラスを継承することで、データベースと簡単にやり取りできるようになります。
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


// Area クラスは Model クラスを継承しており、Eloquent ORMを使用してデータベースと簡単に連携します。これにより、areas テーブルとのデータ操作が簡単に行えるようになります。
class Area extends Model
{
    use HasFactory;

    // $fillable:
// このプロパティは、Eloquent モデルに対して一括代入を許可する属性（カラム）を定義します。
// ここでは area_name というフィールドが一括代入できるように設定されています。つまり、新しい Area を作成する際に、area_name 属性に値を一度に代入できます。
    protected $fillable = ['area_name',];

    public function shops()
    {
// これは リレーションメソッド です。Area と Shop との間に「1対多」の関係を定義しています。
// Area は複数の Shop を持つことができ、hasMany メソッドはそのリレーションを示します。
// 具体的には、Area モデルのインスタンスを通じて、そのエリアに関連する Shop モデルのデータを取得することができます。
        return $this->hasMany(Shop::class);
    }
}

// まとめ
// この Area モデルは、以下の機能を提供しています：

// $fillable プロパティ: area_name を一括代入可能にしています。
// shops メソッド: Area モデルと Shop モデルの「1対多」のリレーションを定義し、特定のエリアに関連するショップ情報を簡単に取得できるようにしています。
// このクラスを使用することで、areas テーブルとその関連する shops テーブルのデータを簡単に操作できるようになります。