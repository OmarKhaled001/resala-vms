<?php

namespace App\Http\Controllers\Volunteer;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ActivityLogsService;

class RoleController extends Controller
{
    
    protected $ActivityLogsService;
    public function __construct(ActivityLogsService $ActivityLogsService)
    {
        $this->ActivityLogsService = $ActivityLogsService;
    }
    
    
    public function allRole() 
    {
        $roles = Role::where('guard_name','super_admin')->get();
        return view('super_admin.role.index',compact('roles'));
        
    }

    public function createForm() 
    {
        return view('super_admin.role.create');
        
    }

    public function editForm($id) 
    {
        $role = Role::with('permissions')->find($id);
        $permissions = config('roles.super_admin');
        return view('super_admin.role.edit', compact('role','permissions'));
        
    }


    public function storeRole(Request $request)
    {
        try {
            // التحقق من صحة البيانات
            $validatedData = $request->validate([
                'display_name' => 'required|string|max:255',
                'name' => 'required|string|max:255|unique:roles,name',
                'description' => 'nullable|string',
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,name',
            ], [
                'display_name.required' => 'اسم الدور مطلوب.',
                'name.required' => 'رمز الدور مطلوب.',
                'name.unique' => 'رمز الدور موجود بالفعل.',
                'permissions.required' => 'يجب اختيار صلاحيات.',
                'permissions.*.exists' => 'إحدى الصلاحيات المحددة غير موجودة في النظام.',
            ]);

            // إنشاء دور جديد
            $role =  new Role();
            $role->name          = $validatedData['name'];
            $role->display_name  = $validatedData['display_name'];
            $role->description   = $validatedData['description'];
            $role->guard_name    = 'super_admin';
            $role->save() ;
            $role->syncPermissions($validatedData['permissions']);
            $causer = auth('super_admin')->user();
            $this->ActivityLogsService->insert([
                'subject' => $role,
                'causer' => $causer,
                'log_name' => 'تم إضافة دور جديد: ' . $role->display_name,
                'description' => 'تم إنشاء الدور: ' . $role->display_name . ' (الاسم: ' . $role->name . ') بتاريخ ' . now()->format('F j, Y g:i A'),
                'event' => 'إضافة',
                'guard' => 'super_admin',
            ]);
            
            return redirect()->route('super_admin.role.index')->with('success', 'تم إنشاء الدور بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء الإنشاء: ' . $e->getMessage());
        }
    }


    public function updateRole(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'display_name' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,name',
            ], [
                'display_name.required' => 'اسم الدور مطلوب.',
                'name.required' => 'رمز الدور مطلوب.',
                'name.unique' => 'رمز الدور موجود بالفعل.',
                'permissions.required' => 'يجب اختيار صلاحيات.',
                'permissions.*.exists' => 'إحدى الصلاحيات المحددة غير موجودة في النظام.',
            ]);

    
            $role = Role::find($request->id) ;
            $role->name          = $validatedData['name'];
            $role->display_name  = $validatedData['display_name'];
            $role->description   = $validatedData['description'];
            $role->guard_name    = 'super_admin';
            $role->save() ;
            $role->syncPermissions($validatedData['permissions']);
            $causer = auth('super_admin')->user();
            $this->ActivityLogsService->insert([
                'subject' => $role,
                'causer' => $causer,
                'log_name' => 'تم تعديل دور: ' . $role->display_name,
                'description' => 'تم تعديل بيانات الدور: ' . $role->display_name . ' (الاسم: ' . $role->name . ') بتاريخ ' . now()->format('F j, Y g:i A'),
                'event' => 'تعديل',
                'guard' => 'super_admin',
            ]);
            
            return redirect()->route('super_admin.role.index')->with('success', 'تم الإنشاء بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء الإنشاء: ' . $e->getMessage());
        }
    }
    
    public function destroyRole($id)
    {
        try {
            Role::findOrFail($id)->delete();
            $role = Role::findOrFail($id);
            $causer = auth('super_admin')->user();
            $this->ActivityLogsService->insert([
                'subject' => $role,
                'causer' => $causer,
                'log_name' => 'تم حذف دور: ' . $role->display_name,
                'description' => 'تم حذف بيانات الدور: ' . $role->display_name . ' (الاسم: ' . $role->name . ') بتاريخ ' . now()->format('F j, Y g:i A'),
                'event' => 'حذف',
                'guard' => 'super_admin',
            ]);
            
            return response()->json(['success' => 'تم حذف اللجنة بنجاح!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف اللجنة: ' . $e->getMessage()], 500);
        }
    }
}
