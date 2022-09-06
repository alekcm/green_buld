<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin', function () {
    return redirect()->route('admin.pages.index');
})->middleware(['auth:web', 'can:isAdmin',]);

require __DIR__ . '/web/auth.php';

Route::prefix('')->name('web.')->group(function () {
    require __DIR__ . '/web/feedbacks.php';
});

Route::prefix('')->name('web.')->middleware('can:isNotBlocked')->group(function () {
    require __DIR__ . '/web/pages.php';
    require __DIR__ . '/web/search.php';
});

Route::prefix('admin')->name('admin.')->group(function () {
    require __DIR__ . '/admin/pages.php';
    require __DIR__ . '/admin/users.php';
    require __DIR__ . '/admin/configs.php';
    require __DIR__ . '/admin/selection_infos.php';
});
