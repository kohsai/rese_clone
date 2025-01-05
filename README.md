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


【　環境構築　】
Dockerビルド

git@github.com:kohsai/rese.git

DockerDesktopアプリを立ち上げる

docker-compose up -d --build


【　Laravel環境構築　】

docker-compose exec php bash composer install

.envに以下の環境変数を追加

DB_CONNECTION=mysql

DB_HOST=mysql

DB_PORT=3306

DB_DATABASE=laravel_db

DB_USERNAME=laravel_user

DB_PASSWORD=laravel_pass


【　アプリケーションキーの作成　】
php artisan key:generate

【　マイグレーションの実行　】
php artisan migrate

【　使用技術（実行環境）】
・PHP: 7.4.9

・Laravel Framework: 8.83.27

・MySQL: 8.0.26

【　テーブル設計　】
![alt text](<スクリーンショット 2025-01-05 145239.png>)

【　ER図　】
![alt text](<スクリーンショット 2025-01-05 152800.png>)

【　URL　】
・開発環境:http://localhost/

・phpMyAdmin:http://localhost:8080
