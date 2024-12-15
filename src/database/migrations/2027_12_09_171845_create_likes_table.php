<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();

            //  user_idという外部キーカラムを作成し、users テーブルの id カラムを参照します。
            $table->foreignId('user_id')->constrained(); // ユーザーID（認証済みユーザーを想定）

            // shop_id という外部キーカラムを作成し、shops テーブルの id カラムを参照します。
            $table->foreignId('shop_id')->constrained(); // 店舗ID
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}

// likesテーブルの構造: ユーザーID、店舗ID、作成日時、更新日時というカラムを持つ likes テーブルを作成します。
// 外部キー制約: user_id と shop_id はそれぞれ、users テーブルと shops テーブルの id カラムを参照する外部キーとなります。これにより、一つのユーザーが一つの店舗に対して複数の「いいね」をすることができ、また、一つの店舗に対して複数のユーザーが「いいね」をすることができます。
// マイグレーション: このコードを実行することで、データベースに likes テーブルが作成されます。また、down メソッドを実行することで、このテーブルを削除できます。