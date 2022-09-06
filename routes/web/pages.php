<?php

use App\Http\Controllers\Web\PageController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

Route::get('', [PageController::class, 'index'])
    ->middleware(['auth:web'])
    ->name('pages.index');

Route::prefix('pages')->name('pages.')->middleware(['auth:web'])->group(function () {
    Route::get('{path}', [PageController::class, 'show'])
        ->where('path', '.*')
        ->name('show');
});
