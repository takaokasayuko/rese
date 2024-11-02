<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

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

Route::middleware(['verified'])->group(function () {
    Route::get('/thanks', [ShopController::class, 'thanks'])->name('thanks');

    Route::post('/favorite/store', [ShopController::class, 'store']);
    Route::delete('/favorite/delete', [ShopController::class, 'destory']);

    Route::get('/detail/{shop_id}', [ShopController::class, 'detail'])->name('shop.detail');
    Route::get('/detail/review/{shop_id}', [ShopController::class, 'detailReview'])->name('detail.review');

    Route::post('/reservation/store', [ReservationController::class, 'store']);
    Route::delete('/reservation/delete', [ReservationController::class, 'destory']);
    Route::patch('/reservation/update', [ReservationController::class, 'update']);

    Route::get('/done', [ReservationController::class, 'done']);

    Route::get('/mypage', [ReservationController::class, 'mypage']);
    Route::get('/mypage/update/{reservation_id}', [ReservationController::class, 'mypageUpdate'])->name('mypage.update');

    Route::get('/review', [ReservationController::class, 'review']);
    Route::patch('/review/update', [ReservationController::class, 'reviewUpdate']);

    Route::get('/admin', [AdminController::class, 'admin']);
    Route::post('/admin/store', [AdminController::class, 'adminStore']);
    Route::get('/owner/register', [AdminController::class, 'ownerRegister']);
    Route::get('/owner/reservation', [AdminController::class, 'ownerReservation']);
    Route::get('/owner/shop', [AdminController::class, 'ownerShop']);
});

Route::get('/', [ShopController::class, 'index']);
Route::get('/search', [ShopController::class, 'search']);

// メール再送信
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


