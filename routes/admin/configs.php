<?php

use App\Http\Controllers\Admin\ConfigController;

Route::prefix('configs')->name('configs.')->middleware(['auth:web', 'can:isAdmin',])->group(function () {

    Route::get('', [ConfigController::class, 'index'])
        ->name('index');

    Route::get('{attr}/edit', [ConfigController::class, 'edit'])
        ->name('edit');

    Route::put('{attr}', [ConfigController::class, 'update'])
        ->name('update');
});
