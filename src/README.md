#アプリケーション名
勤怠管理アプリ

＃＃環境構築

## ① リポジトリ取得
## ① リポジトリ取得
git clone https://github.com/suzuka-us/laravel-kintai.git
cd laravel-kintai


## ② Dockerビルド

docker compose build

## ③ コンテナ起動

docker compose up -d

## ④ phpコンテナに入る

docker compose exec php bash

## ⑤ 依存パッケージインストール

composer install

## ⑥ .env作成

cp .env.example .env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

## ⑦ APP_KEY生成

php artisan key:generate

## ⑧ マイグレーション

php artisan migrate

## ⑨ シーディング

php artisan db:seed

## ⑩ 動作確認

http://localhost
http://localhost:8080

＃＃使用技術

## 使用技術

・Laravel 10
・PHP 8.2.30
・MySQL 8.0.26

＃＃URL
環境開発：http://localhost/
phpmyadmin:http://localhost:8080

＃＃ER図
![alt text](kintai.png)
