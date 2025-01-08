<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Section;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function allActivity() 
    {
        $activities = Activity::all();
        return view('super_admin.activity.index',compact('activities'));
        
    }
    public function showForm() 
    {
        $sections = Section::all();
        return view('super_admin.activity.create',compact('sections'));
        
    }

    public function storeActivity(Request $request)
    {

        return response($request);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:activitys,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'الاسم يجب أن يكون نصًا.',
            'name.max' => 'الاسم يجب ألا يزيد عن 255 حرفًا.',
            
            'username.required' => 'حقل اسم المستخدم مطلوب.',
            'username.string' => 'اسم المستخدم يجب أن يكون نصًا.',
            'username.max' => 'اسم المستخدم يجب ألا يزيد عن 255 حرفًا.',
            'username.unique' => 'اسم المستخدم مُستخدم بالفعل.',
    
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.email' => 'البريد الإلكتروني يجب أن يكون صيغة صحيحة.',
            'email.unique' => 'البريد الإلكتروني مُستخدم بالفعل.',
    
            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.string' => 'كلمة المرور يجب أن تكون نصًا.',
            'password.min' => 'كلمة المرور يجب ألا تقل عن 8 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ]);
    
        $activity = new Activity();
        $activity->name = $validatedData['name'];
        $activity->username = $validatedData['username'];
        $activity->email = $validatedData['email'];
        $activity->password = bcrypt($validatedData['password']); 
        $activity->save();
    
        return redirect()->back()->with('success', 'تم الإنشاء بنجاح!');
    }
}
