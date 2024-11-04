#!/bin/bash

# 実行ディレクトリを変数に設定
BASE_DIR="/var/www/html"

# エラー時にスクリプトを停止
set -e

# 作業ディレクトリに移動
cd "$BASE_DIR"

# vendorディレクトリが存在しない場合、composer installを実行
if [ ! -d vendor ]; then
    echo "Running composer install..."
    composer install || { echo "Composer install failed"; exit 1; }

else
    echo "Dependencies are already installed."
fi

# .envファイルが存在しない場合、初期設定をする
if [ ! -f .env ]; then
    echo "Copying .env.sample to .env..."
    cp .env.sample .env

    echo "Generating application key..."
    php artisan key:generate
    php artisan config:cache

else
    echo ".env file already exists."
fi

# storageとcacheディレクトリに書き込み権限を付与
echo "Setting write permissions for storage and cache directories..."
chmod -R a+w storage/ bootstrap/cache

# public/storageへのシンボリックリンクが存在しない場合、storage:linkを実行
if [ ! -L public/storage ]; then
    echo "Running php artisan storage:link..."
    php artisan storage:link
else
    echo "Symbolic link for storage already exists."
fi

