<?php

use App\Http\Controllers\Admin\UserController;

Route::prefix('users')->name('users.')->middleware(['auth:web', 'can:isAdmin',])->group(function () {

    Route::get('', [UserController::class, 'index'])
        ->name('index');

    Route::get('{id}/edit', [UserController::class, 'edit'])
        ->name('edit');

    Route::put('{id}', [UserController::class, 'update'])
        ->name('update');

    Route::put('{id}/block', [UserController::class, 'block'])
        ->name('block');
});
