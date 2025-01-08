<?php

namespace App\Http\Controllers\Volunteer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('volunteer.auth.login');
    }

    public function login(Request $request)
    {

        $credentials = ['username' => $request->username, 'password' => $request->password];

        if (Auth::guard('volunteer')->attempt($credentials)) {
            return redirect(route('volunteer.index'));
        }
        flash()->error('هناك خطأ في البريد الالكتروني او كلمة المرور');
        return redirect(route('volunteer.login'));
    }


   
    public function logout()
    {
        Auth::guard('volunteer')->logout();
        return redirect(route('volunteer.login'));
    }

}
