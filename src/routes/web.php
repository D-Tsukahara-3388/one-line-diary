<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::prefix('/memory')->as('memory.')->group(function () {
    Route::get('/', [App\Http\Controllers\MemoryController::class, 'index'])
        ->name('index');
    Route::get('/add', [App\Http\Controllers\MemoryController::class, 'add'])
        ->name('add');
    Route::post('/create', [App\Http\Controllers\MemoryController::class, 'create'])
        ->name('create');
    Route::get('/edit/{memory}', [App\Http\Controllers\MemoryController::class, 'edit'])
        ->name('edit');
    Route::patch('/update/{memory}', [App\Http\Controllers\MemoryController::class, 'update'])
        ->name('update');
    Route::delete('/delete/{memory}', [App\Http\Controllers\MemoryController::class, 'delete'])
        ->name('delete');
});
