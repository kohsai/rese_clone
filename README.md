# サービス名　【 Rese(リーズ) 】
![スクリーンショット 2024-10-28 095041](https://github.com/user-attachments/assets/5ee0a169-cb0f-41d7-b76b-38757b40cf0e)
ある企業のグループ会社の飲食店予約サービス

【　目的　】
外部の飲食店予約サービスは手数料を取られるので自社で予約サービスを持ちたい。

【　機能一覧　】

/	　         飲食店一覧ページ

/register	　 会員登録ページ

/thanks	     サンクスページ

/login	　   ログインページ

/mypage	　   マイページ

/shops/{shop_id}	飲食店詳細ページ

/done	　　   予約完了ページ

（※ /shops/create  新規店舗追加ページ）


【　環境構築　】
Dockerビルド

git@github.com:kohsai/rese_clone.git


DockerDesktopアプリを立ち上げる

docker-compose up -d --build


【 MySQLデータベースと権限の設定 】

DockerコンテナでMySQLデータベースが自動作成されるよう設定済みです。

作成される内容：

データベース名: laravel_db

ユーザー名: laravel_user

パスワード: laravel_pass

必要な設定は docker-compose.yml に記述済みです。

もし、MySQLユーザーやデータベースが作成されていない場合、以下の手順で作成します。

【 MySQLユーザーの作成と権限の設定 】

MySQLコンテナにログイン後、以下のコマンドで laravel_user ユーザーを作成し、必要な権限を付与します。

docker-compose exec mysql bash

<!-- rootパスワードを入力してMySQLにログイン -->
mysql -u root -p

MySQLにログインした後、以下を実行してユーザーと権限を設定します。

CREATE USER 'laravel_user'@'%' IDENTIFIED BY 'laravel_pass';

GRANT ALL PRIVILEGES ON laravel_db.* TO 'laravel_user'@'%';

FLUSH PRIVILEGES;


【 MySQLデータベースの作成 】

MySQL内でデータベース laravel_db が作成されていない場合、以下のSQLを実行してデータベースを作成します。

CREATE DATABASE laravel_db;


【 ストレージディレクトリの権限設定 】

Laravelのログやキャッシュの書き込みができるように、storage ディレクトリに権限を設定します。以下のコマンドを実行して、権限を変更してください。

docker-compose exec php chmod -R 775 /var/www/storage

docker-compose exec php chown -R www-data:www-data /var/www/storage

これで、Laravelがログやキャッシュを正常に書き込めるようになります。



【　Laravel環境構築　】

docker-compose exec php bash

composer install


【 .env ファイルを作成 】

プロジェクトをクローンした場合、.env ファイルが存在しないため、次の手順で作成します。

.env.example ファイルを .env ファイルとしてコピーします。

cp .env.example .env


.env ファイルを編集し、以下の内容を確認または修正してください。

.envに以下の環境変数を追加


DB_CONNECTION=mysql

DB_HOST=mysql

DB_PORT=3306

DB_DATABASE=laravel_db

DB_USERNAME=laravel_user

DB_PASSWORD=laravel_pass


【 .env ファイルの権限を設定します。 】

docker-compose exec php chmod 644 /var/www/.env

docker-compose exec php chown www-data:www-data /var/www/.env



【　アプリケーションキーの作成　】

php artisan key:generate

【　マイグレーションの実行　】

php artisan migrate


【　初期データの登録（シードの実行）　】

php artisan migrate --seed

注意:
シードの実行により、エリアやジャンル、店舗情報の初期データがデータベースに挿入されます。この操作は必須です。


【　使用技術（実行環境）】

・PHP: 7.4.9

・Laravel Framework: 8.83.27

・MySQL: 8.0.26

【　テーブル設計　】

![alt text](<スクリーンショット 2025-01-05 145239.png>)

【　ER図　】

![alt text](<スクリーンショット 2025-01-05 152800-1.png>)


【　URL　】
・開発環境:http://localhost/

・phpMyAdmin:http://localhost:8080
