<?php

use App\Http\Controllers\Admin\SelectionInfoController;

Route::prefix('selection-info')->name('selection_info.')->middleware(['auth:web', 'can:isAdmin',])->group(function () {

    Route::get('', [SelectionInfoController::class, 'create'])
        ->name('create');

    Route::post('', [SelectionInfoController::class, 'store'])
        ->name('store');

    Route::post('upload', [SelectionInfoController::class, 'upload'])
        ->name('upload');
});
