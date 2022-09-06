<?php

use App\Http\Controllers\Admin\PageController;

Route::prefix('pages')->name('pages.')->middleware(['auth:web', 'can:isAdmin',])->group(function () {

    Route::get('', [PageController::class, 'index'])
        ->name('index');

    Route::get('create', [PageController::class, 'create'])
        ->name('create');

    Route::post('', [PageController::class, 'store'])
        ->name('store');

    Route::get('{slug}/edit', [PageController::class, 'edit'])
        ->name('edit');

    Route::put('{slug}', [PageController::class, 'update'])
        ->name('update');

    Route::delete('{slug}', [PageController::class, 'destroy'])
        ->name('destroy');

    Route::post('/save-icon', [PageController::class, 'saveIcon'])
        ->name('save-icon');

    Route::post('/delete-icon', [PageController::class, 'deleteIcon'])
        ->name('delete-icon');

    Route::post('/upload-image', [PageController::class, 'uploadImage'])
        ->name('upload-image');
});
