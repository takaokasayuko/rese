<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
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

// ユーザー
Route::middleware(['check.user', 'verified'])->group(function () {
    Route::get('/thanks', [ShopController::class, 'thanks'])->name('thanks');

    Route::post('/favorite/store', [ShopController::class, 'store']);
    Route::delete('/favorite/delete', [ShopController::class, 'destory']);

    Route::post('/reservation/store', [ReservationController::class, 'store']);
    Route::delete('/reservation/delete', [ReservationController::class, 'destory']);
    Route::patch('/reservation/update', [ReservationController::class, 'update']);

    Route::get('/done', [ReservationController::class, 'done']);

    Route::get('/mypage', [ReservationController::class, 'mypage']);
    Route::get('/mypage/update/{reservation_id}', [ReservationController::class, 'mypageUpdate'])->name('mypage.update');

    Route::get('/review', [ReservationController::class, 'review']);
    Route::patch('/review/update', [ReservationController::class, 'reviewUpdate']);

    Route::get('/credit', [ReservationController::class, 'credit']);
    Route::post('/credit/store', [ReservationController::class, 'creditStore']);

    Route::get('/review/{shop_id}', [ReviewController::class, 'review'])->name('review.posting');
    Route::post('/review', [ReviewController::class, 'create']);

    Route::get('/review/edit/{shop_id}', [ReviewController::class, 'edit'])->name('review.edit');
    Route::patch('/review/update', [ReviewController::class, 'update']);

});

// 管理者
Route::middleware(['check.admin', 'verified'])->group(
    function () {
        Route::get('/admin', [AdminController::class, 'admin']);
        Route::post('/admin/store', [AdminController::class, 'adminStore']);
        Route::get('/admin/email', [AdminController::class, 'mail']);
        Route::post('/admin/email/send', [AdminController::class, 'send']);

        Route::get('/admin/import', [AdminController::class, 'import']);
        Route::post('/admin/import/csv', [AdminController::class, 'csvImport']);
    });

// 管理者とユーザー
Route::middleware(['check.admin_or_user', 'verified'])->group(
    function () {
        Route::delete('/review/delete', [ReviewController::class, 'destroy']);
    }
);

// 店舗管理者
Route::middleware(['check.owner', 'verified'])->group(
    function () {
    Route::get('/owner/register', [AdminController::class, 'ownerRegister']);
    Route::post('/owner/store', [AdminController::class, 'ownerStore']);
    Route::get('/owner/shop', [AdminController::class, 'ownerShop']);
    Route::get('/owner/reservation/{shop_id}', [AdminController::class, 'ownerReservation'])->name('owner.reservation');

    Route::get('/owner/payment/{reservation_id}', [AdminController::class, 'payment'])->name('owner.payment');
    Route::post('/owner/payment/store/', [AdminController::class, 'paymentStore']);
    }
);

// ゲスト
Route::get('/', [ShopController::class, 'index']);
Route::get('/search', [ShopController::class, 'search']);
Route::get('/detail/{shop_id}', [ShopController::class, 'detail'])->name('shop.detail');
Route::get('/detail/review/{shop_id}', [ShopController::class, 'detailReview'])->name('detail.review');
Route::get('/confirmation/{reservation_id}', [ReservationController::class, 'confirmation'])->name('confirmation');


// メール再送信
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


