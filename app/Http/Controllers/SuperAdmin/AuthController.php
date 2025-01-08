<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('super_admin.auth.login');
    }

    public function login(Request $request)
    {

        $credentials = ['username' => $request->username, 'password' => $request->password];

        if (Auth::guard('super_admin')->attempt($credentials)) {
            return redirect(route('super_admin.index'));
        }
        flash()->error('هناك خطأ في البريد الالكتروني او كلمة المرور');
        return redirect(route('super_admin.login'));
    }


   
    public function logout()
    {
        Auth::guard('super_admin')->logout();
        return redirect(route('super_admin.login'));
    }

}
