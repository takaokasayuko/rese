<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;

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

    Route::get('/detail/{shop_id}', [ShopController::class, 'detail'])->name('shop.detail');

    Route::post('/reservation/store', [ReservationController::class, 'store']);
    Route::delete('/reservation/delete', [ReservationController::class, 'destory']);
    Route::patch('/reservation/update', [ReservationController::class, 'update']);

    Route::get('/done', [ReservationController::class, 'done']);

    Route::get('/mypage', [ReservationController::class, 'mypage']);
    Route::get('/mypage/update/{reservation_id}', [ReservationController::class, 'mypageUpdate'])->name('mypage.update');

    Route::get('/review', [ReservationController::class, 'review']);
    Route::patch('/review/update', [ReservationController::class, 'reviewUpdate']);

});

Route::get('/', [ShopController::class, 'index']);
Route::get('/search', [ShopController::class, 'search']);


