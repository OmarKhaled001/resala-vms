<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\User;
use Laratrust\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\UserRequest;

class UserController extends Controller
{
    public function allUser()
    {
        $users = User::all();
        $roles = Role::where('guard_name','super_admin')->get();
        return view('super_admin.user.index', compact('users','roles'));
    }

    public function storeUser(UserRequest $request)
    {
        try {
            $validatedData = $request->validated();
    
            $user = new User();
            $user->name = $validatedData['name'];
            $user->username = $validatedData['username'];
            $user->email = $validatedData['email'];
            $user->password = bcrypt($validatedData['password']);
            $user->save();
    
            $user->roles()->sync([$validatedData['role_id']]);
    
            $role = Role::findOrFail($validatedData['role_id']);
            $permissions = $role->permissions->pluck('name')->toArray();
    
            $user->syncPermissions($permissions);
    
            return redirect()->route('super_admin.user.index')->with('success', 'تم الإنشاء بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء الإنشاء: ' . $e->getMessage());
        }
    }
    

    public function updateUser(UserRequest $request)
    {
        try {
            $validatedData = $request->validated();
    
            $user = User::findOrFail($request->id);
            $user->name = $validatedData['name'];
            $user->username = $validatedData['username'];
            $user->email = $validatedData['email'];
            
            if (!empty($validatedData['password'])) {
                $user->password = bcrypt($validatedData['password']);
            }
            
            $user->save();
    
            $user->roles()->sync([$validatedData['role_id']]);
    
            $role = Role::findOrFail($validatedData['role_id']);
            $permissions = $role->permissions->pluck('name')->toArray();
    
            $user->syncPermissions($permissions);
    
            return redirect()->route('super_admin.user.index')->with('success', 'تم التحديث بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء التحديث: ' . $e->getMessage());
        }
    }
    
    public function destroyUser($id)
    {
        try {
            User::findOrFail($id)->delete();
    
            return response()->json(['success' => 'تم حذف المشاركة بنجاح!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف المشاركة: ' . $e->getMessage()], 500);
        }
    }
}
