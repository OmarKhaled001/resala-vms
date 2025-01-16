<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogsService;

class AuthController extends Controller
{

    protected $ActivityLogsService;
    public function __construct(ActivityLogsService $ActivityLogsService)
    {
        $this->ActivityLogsService = $ActivityLogsService;
    }
    
    public function loginView()
    {
        return view('super_admin.auth.login');
    }

    public function login(Request $request)
    {

        $credentials = ['username' => $request->username, 'password' => $request->password];
        if (Auth::guard('super_admin')->attempt($credentials)) {
            $causer = auth('super_admin')->user();
            $this->ActivityLogsService->insert([
                'subject' => $causer,
                'causer' => $causer,
                'log_name' => 'تم تسجيل الدخول بنجاح',
                'description' => 'قام المستخدم ' . $causer->name . ' بتسجيل الدخول بنجاح بتاريخ ' . now()->format('F j, Y g:i A'),
                'event' => 'تسجيل الدخول',
                'guard' => 'super_admin',
            ]);
            
            return redirect(route('super_admin.index'));
        }
        flash()->error('هناك خطأ في البريد الالكتروني او كلمة المرور');
        return redirect(route('super_admin.login'));
    }


   
    public function logout()
    {
       
        $causer = auth('super_admin')->user(); 
        $this->ActivityLogsService->insert([
            'subject' => $causer,
            'causer' => $causer,
            'log_name' => 'تم تسجيل الخروج',
            'description' => 'قام المستخدم ' . $causer->name . ' بتسجيل الخروج بتاريخ ' . now()->format('F j, Y g:i A'),
            'event' => 'تسجيل الخروج',
            'guard' => 'super_admin',
        ]);
        Auth::guard('super_admin')->logout();
        return redirect(route('super_admin.login'));
    }

}
