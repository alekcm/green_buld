<?php

use App\Http\Controllers\Web\FeedbackController;

Route::prefix('feedbacks')->name('feedbacks.')->group(function () {
    Route::post('', [FeedbackController::class, 'store'])
        ->name('store');
});
