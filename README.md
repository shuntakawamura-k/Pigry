# Pigry

## アプリケーション概要
体重管理アプリ

## 環境構築

### 1. リポジトリのクローン
```bash
git clone https://github.com/shuntakawamura-k/Pigry.git
cd Pigry

docker-compose up -d --build
docker-compose exec php bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

動作確認
ブラウザで以下のURLにアクセスします。

新規会員登録画面: http://localhost/register

ログイン画面: http://localhost/login

テスト用ログイン情報（ログイン確認用）

メールアドレス: test@example.com

パスワード: password123
