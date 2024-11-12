<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\ShopRegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;
use App\Consts\GenreConst;
use App\Consts\PrefectureConst;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminMail;

class AdminController extends Controller
{
    // 管理者
    public function admin()
    {
        return view('admin.admin');
    }

    // 店舗代表登録
    public function adminStore(AdminRegisterRequest $request)
    {
        $request['admin'] = 1;
        $request['password'] = bcrypt($request['password']);
        unset($request['_token']);
        User::create($request->all());

        return redirect('/admin')->with('message', '登録しました');
    }

    // 店舗登録画面
    public function ownerRegister()
    {
        $areas = PrefectureConst::PREFECTURES;
        $genres = GenreConst::GENRES;

        return view('admin.shop-registration', compact('areas', 'genres'));
    }

    // 店舗登録
    public function ownerStore(ShopRegisterRequest $request)
    {
        $user = Auth::user();
        $data = [
            'user_id' => $user->id,
            'name' => $request->name,
            'area' => $request->area,
            'genre' => $request->genre,
            'image' => $request->file('image')->store('image', 'public'),
            'detail' => $request->detail,
        ];
        Shop::create($data);

        return redirect('/owner/register')->with('message', '登録しました');
    }

    // 登録店舗一覧
    public function ownerShop()
    {
        $user = Auth::user();
        $shops = Shop::where('user_id', $user->id)
            ->with(['shopReservations' => function ($query) {
                $query->latest('updated_at');
            }])
            ->orderByDesc(function ($query) {
                $query->select('updated_at')
                    ->from('reservations')
                    ->whereColumn('reservations.shop_id', 'shops.id')
                    ->latest('updated_at')
                    ->limit(1);
            })
            ->get();

        return view('admin.owner', compact('shops'));
    }

    // 予約確認
    public function ownerReservation($shop_id, Request $request)
    {
        $user = Auth::user()->id;
        $shop = Shop::find($shop_id);
        if (!$user === $shop['user_id']) {
            return view('error');
        }
        $date = $request->input('date', Carbon::now()->toDateString());
        $reservations = Reservation::where('shop_id', $shop_id)
            ->whereDate('date', $date)
            ->oldest('date')
            ->with('reservationUser')
            ->get();

        return view('admin.reservation', compact('reservations', 'date', 'shop_id'));
    }

    // メール送信
    public function mail()
    {
        return view('admin.admin-email');
    }

    public function send(Request $request)
    {
        $subject = $request->input('subject');
        $message_content = $request->input('message');
        $users = User::all();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new AdminMail($subject, $message_content));
        }

        return back()->with('message', '送信しました');
    }
}
