<?php

use App\Http\Controllers\Api\V1\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {

    Route::prefix('todos')->name('todos.')->group(function() {
        Route::get('', [TodoController::class, 'index'])->name('index');
        Route::post('', [TodoController::class, 'store'])->name('store');
        Route::put('{todo}', [TodoController::class, 'update'])->name('update');
        Route::delete('{todo}', [TodoController::class, 'destroy'])->name('destroy');
    });
}); 