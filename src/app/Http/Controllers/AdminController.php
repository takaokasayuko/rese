<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminRegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Shop;

class AdminController extends Controller
{
    public function admin()
    {
        return view('admin.admin');
    }

    public function adminStore(Request $request)
    {
        $request['admin'] = 1;
        $request['password'] = bcrypt($request['password']);
        unset($request['_token']);
        User::create($request->all());

        return redirect('/admin')->with('message', '登録しました');
    }

    public function shopRegister()
    {
        return view('admin.shop-registration');
    }
    public function shopReservation()
    {
        return view('admin.reservation');
    }
}
