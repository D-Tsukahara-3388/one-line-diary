<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\MemoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/image/{userId}/{fileName}', [ImageController::class, 'show']);

Route::prefix('/memory')->as('memory.')->group(function () {
    Route::get('/', [MemoryController::class, 'index'])
        ->name('index');
    Route::get('/add', [MemoryController::class, 'add'])
        ->name('add');
    Route::post('/create', [MemoryController::class, 'create'])
        ->name('create');
    Route::get('/edit/{memory}', [MemoryController::class, 'edit'])
        ->name('edit');
    Route::patch('/update/{memory}', [MemoryController::class, 'update'])
        ->name('update');
    Route::delete('/delete/{memory}', [MemoryController::class, 'delete'])
        ->name('delete');
});
