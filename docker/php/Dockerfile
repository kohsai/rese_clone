FROM php:7.4.9-fpm

COPY php.ini /usr/local/etc/php/

RUN apt update \
    && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install pdo_mysql zip


# Composer とは、PHP で作るアプリケーションで必要となるライブラリなどのパッケージを管理するツールです。
# Composer は、「セットアップ」のセクションで、ビルドした PHPコンテナにインストールしてあります。
# docker/php/ディレクトリ、Dockerfileの以下の部分がその記述になります。
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

WORKDIR /var/www

#　　 項目	　　　　　　　　　説明
# FROM php:7.4.9-fpm	　バージョン 7.4.9 の PHP をインストールしています。
# COPY 省略	　　　　　　　　別途作成されたphp.iniをコンテナ内の/usr/local/etc/php/にコピーします
# RUN 省略	　　　　　　　　起動時に必要なコマンドを実行しています。以下で詳細説明します。
# WORKDIR /var/www	　　　　コンテナ内の/var/www/をワーキングディレクトリに設定します。


# Composer は PHPコンテナから 操作します。 docker-composeコマンドでコンテナ内にログインしましょう。
# $ docker-compose exec php bash
# ログインができたら、composerがインストールできているかを以下のコマンドで確かめてみましょう。
# $ composer -v
# Composer version 2.3.3 2022-04-01 22:15:35
# 上記のように出力されていれば、成功です。

