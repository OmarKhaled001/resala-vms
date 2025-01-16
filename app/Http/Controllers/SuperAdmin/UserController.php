<?php

namespace App\Http\Controllers\SuperAdmin;

use Exception;
use App\Models\User;
use Laratrust\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\ActivityLogsService;
use App\Http\Requests\SuperAdmin\UserRequest;

class UserController extends Controller
{
    protected $ActivityLogsService;
    public function __construct(ActivityLogsService $ActivityLogsService)
    {
        $this->ActivityLogsService = $ActivityLogsService;
    }
    public function allUser()
    {
        $users = User::all();
        $roles = Role::where('guard_name', 'super_admin')->get();
        return view('super_admin.user.index', compact('users', 'roles'));
    }

    public function storeUser(UserRequest $request)
    {
        DB::beginTransaction();
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

            $causer = auth('super_admin')->user();
            $this->ActivityLogsService->insert([
                'subject'     => $user,
                'causer'      => $causer,
                'log_name'    => 'تم انشاء مستخدم: ' . $user->name,
                'description' => 'تم انشاء مستخدم جديد: ' . $user->name . ' (اسم المستخدم: ' . $user->username . ')  مع دور: ' . $role->display_name,
                'event'       => 'إنشاء',
                'guard'       => 'super_admin',
            ]);

            DB::commit();
            return redirect()->route('super_admin.user.index')->with('success', 'تم الإنشاء بنجاح!');
        } catch (Exception $e) {
            DB::rollBack();
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
            $causer = auth('super_admin')->user();
            $this->ActivityLogsService->insert([
                'subject' => $user,
                'causer' => $causer,
                'log_name' => 'تم تعديل مستخدم: ' . $user->name,
                'description' => 'تم تعديل بيانات المستخدم: ' . $user->name . ' (اسم المستخدم: ' . $user->username . ') بتاريخ ' . now()->format('F j, Y g:i A') . ' مع دور: ' . $role->display_name,
                'event' => 'تعديل',
                'guard' => 'super_admin',
            ]);

            return redirect()->route('super_admin.user.index')->with('success', 'تم التحديث بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء التحديث: ' . $e->getMessage());
        }
    }

    public function destroyUser($id)
    {
        try {
            $causer = auth('super_admin')->user();
            $user = User::findOrFail($id);
             User::findOrFail($id)->delete();
            $this->ActivityLogsService->insert([
                'subject' => $user,
                'causer' => $causer,
                'log_name' => 'تم حذف مستخدم: ' . $user->name,
                'description' => 'تم حذف بيانات المستخدم: ' . $user->name . ' (اسم المستخدم: ' . $user->username . ') بتاريخ ' . now()->format('F j, Y g:i A') . ' مع الدور السابق ' ,
                'event' => 'حذف',
                'guard' => 'super_admin',
            ]);
            
            return response()->json(['success' => 'تم حذف المشاركة بنجاح!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف المشاركة: ' . $e->getMessage()], 500);
        }
    }
}
