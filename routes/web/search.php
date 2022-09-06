<?php

use App\Http\Controllers\Web\SearchController;

Route::prefix('search')->name('search.')->middleware(['auth:web'])->group(function () {

    Route::get('', [SearchController::class, 'index'])
        ->name('index');
});
