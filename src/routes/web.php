<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\MemoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

// 画像表示用
Route::get('/image/{userId}/{fileName}', [ImageController::class, 'show']);

// 日記
Route::prefix('/memory')->as('memory.')->group(function () {
    // 一覧
    Route::get('/', [MemoryController::class, 'index'])
        ->name('index');
    // 新規投稿
    Route::get('/add', [MemoryController::class, 'add'])
        ->name('add');
    // 登録処理
    Route::post('/create', [MemoryController::class, 'create'])
        ->name('create');
    // 投稿編集
    Route::get('/edit/{memory}', [MemoryController::class, 'edit'])
        ->name('edit');
    // 更新処理
    Route::patch('/update/{memory}', [MemoryController::class, 'update'])
        ->name('update');
    // 削除処理
    Route::delete('/delete/{memory}', [MemoryController::class, 'delete'])
        ->name('delete');
});
