<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/thanks', [ShopController::class, 'thanks'])->name('thanks');

    Route::post('/favorite/store', [ShopController::class, 'store']);
    Route::delete('/favorite/delete', [ShopController::class, 'destory']);
});

Route::get('/', [ShopController::class, 'index']);
Route::get('/search', [ShopController::class, 'search']);


