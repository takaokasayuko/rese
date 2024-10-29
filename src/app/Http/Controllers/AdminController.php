<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin()
    {
        return view('admin.admin');
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
