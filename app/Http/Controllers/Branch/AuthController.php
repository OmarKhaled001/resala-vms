<?php

namespace App\Http\Controllers\Branch;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('branch.auth.login');
    }

    public function login(Request $request)
    {

        $credentials = ['username' => $request->username, 'password' => $request->password];

        if (Auth::guard('branch')->attempt($credentials)) {
            return redirect(route('branch.index'));
        }
        flash()->error('هناك خطأ في البريد الالكتروني او كلمة المرور');
        return redirect(route('branch.login'));
    }


   
    public function logout()
    {
        Auth::guard('branch')->logout();
        return redirect(route('branch.login'));
    }

}
