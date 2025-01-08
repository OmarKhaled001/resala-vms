<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SectionController extends Controller
{
    public function showForm() 
    {
        return view('super_admin.section.create');
        
    }

    public function storeSection(Request $request)
    {
        // التحقق من صحة البيانات مع تخصيص الرسائل
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:sections,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'الاسم يجب أن يكون نصًا.',
            'name.max' => 'الاسم يجب ألا يزيد عن 255 حرفًا.',
 
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.email' => 'البريد الإلكتروني يجب أن يكون صيغة صحيحة.',
            'email.unique' => 'البريد الإلكتروني مُستخدم بالفعل.',
    
            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.string' => 'كلمة المرور يجب أن تكون نصًا.',
            'password.min' => 'كلمة المرور يجب ألا تقل عن 8 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ]);
    
        $section = new Section();
        $section->name = $validatedData['name'];
        $section->email = $validatedData['email'];
        $section->password = bcrypt($validatedData['password']); 
        $section->save();
    
        return redirect()->back()->with('success', 'تم الإنشاء بنجاح!');
    }
    

    public function getContributions(Request $request)
    {
        $sectionId = $request->get('section_id');
        $section = Section::with('contributions')->find($sectionId);
    
        if ($section) {
            $contributions = $section->contributions;
            return response()->json($contributions);
        }
    
        return response()->json([], 404);
    }
    
}
