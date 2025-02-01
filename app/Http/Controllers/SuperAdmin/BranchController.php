<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Group;
use App\Models\Branch;
use App\Models\Section;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Services\ActivityLogsService;
use App\Http\Requests\SuperAdmin\BranchRequest;

class BranchController extends Controller
{

    protected $ActivityLogsService;
    
    public function __construct(ActivityLogsService $ActivityLogsService)
    {
        $this->ActivityLogsService = $ActivityLogsService;
        $this->middleware('permissionMiddleware:read-branch,super_admin')->only('allBranch');
        $this->middleware('permissionMiddleware:create-branch,super_admin')->only('createForm');
        $this->middleware('permissionMiddleware:create-branch,super_admin')->only('storeBranch');
        $this->middleware('permissionMiddleware:update-branch,super_admin')->only('editForm');
        $this->middleware('permissionMiddleware:update-branch,super_admin')->only('updateBranch');
        $this->middleware('permissionMiddleware:delete-branch,super_admin')->only('destroyBranch');
    }
    
    
    public function allBranch() 
    {
        $branches = Branch::all();
        return view('super_admin.branch.index',compact('branches'));
        
    }

    public function createForm() 
    {
        $activities = Activity::all();
        return view('super_admin.branch.create', compact('activities'));
        
    }

    public function editForm($id) 
    {
        $branch = Branch::find($id);
        $activities = Activity::all();
        return view('super_admin.branch.edit', compact('branch','activities'));
        
    }

    public function storeBranch(BranchRequest $request)
    {
        try {
            $validatedData = $request->validated();
    
            $branch =  new Branch();
            $branch->name = $validatedData['name'];
            $branch->username = $validatedData['username'] ;
            $branch->email = $validatedData['email'] ;
            $branch->password = bcrypt($validatedData['password']) ?? bcrypt($validatedData['username']) ;
            $branch->save();
            $causer = auth('super_admin')->user();
            $this->ActivityLogsService->insert([
                'subject' => $branch,
                'causer' => $causer,
                'log_name' => 'تم إضافة فرع جديد: ' . $branch->name,
                'description' => 'تم إنشاء الفرع: ' . $branch->name . ' (اسم المستخدم: ' . $branch->username . '، البريد الإلكتروني: ' . $branch->email . ') بتاريخ ' . now()->format('F j, Y g:i A'),
                'event' => 'إضافة',
                'guard' => 'super_admin',
            ]);
            
            $branch->activities()->sync($validatedData['activity_id']);
             $groups = collect($validatedData['activity_id'])->map(function ($activity_id) use ($branch) {
            $activity = Activity::find($activity_id);
            return [
                    'name' => $branch->name . ' - ' . $activity->name,
                    'branch_id' => $branch->id,
                    'activity_id' => $activity_id,
                    'is_active' => 1,
                ];
            });

        Group::insert($groups->toArray());

            return redirect()->route('super_admin.branch.index')->with('success', 'تم الإنشاء بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء الإنشاء: ' . $e->getMessage());
        }
    }

    public function updateBranch(BranchRequest $request)
    {
        try {
            $validatedData = $request->validated();
    
            $branch = Branch::find($request->id) ;
            $branch->name = $validatedData['name'];
            $branch->username = $validatedData['username'];
            $branch->email = $validatedData['email'];
    
            if (!empty($validatedData['password'])) {
                $branch->password = bcrypt($validatedData['password']);
            }
    
            $branch->save();
            $causer = auth('super_admin')->user();
            $this->ActivityLogsService->insert([
                'subject' => $branch,
                'causer' => $causer,
                'log_name' => 'تم تعديل بيانات فرع: ' . $branch->name,
                'description' => 'تم تعديل بيانات الفرع: ' . $branch->name . ' (اسم المستخدم: ' . $branch->username . '، البريد الإلكتروني: ' . $branch->email . ') بتاريخ ' . now()->format('F j, Y g:i A'),
                'event' => 'تعديل',
                'guard' => 'super_admin',
            ]);
            
            $branch->activities()->sync($validatedData['activity_id']);
             $groups = collect($validatedData['activity_id'])->map(function ($activity_id) use ($branch) {
            $activity = Activity::find($activity_id);
            return [
                    'name' => $branch->name . ' - ' . $activity->name,
                    'branch_id' => $branch->id,
                    'activity_id' => $activity_id,
                    'is_active' => 1,
                ];
            });

        Group::insert($groups->toArray());
            return redirect()->route('super_admin.branch.index')->with('success', 'تم الإنشاء بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء الإنشاء: ' . $e->getMessage());
        }
    }
    
    public function destroyBranch($id)
    {
        try {
            Branch::findOrFail($id)->delete();
            $branch = Branch::findOrFail($id)->delete();
            $causer = auth('super_admin')->user();
            $this->ActivityLogsService->insert([
                'subject' => $branch,
                'causer' => $causer,
                'log_name' => 'تم حذف فرع: ' . $branch->name,
                'description' => 'تم حذف الفرع: ' . $branch->name . ' (اسم المستخدم: ' . $branch->username . '، البريد الإلكتروني: ' . $branch->email . ') بتاريخ ' . now()->format('F j, Y g:i A'),
                'event' => 'حذف',
                'guard' => 'super_admin',
            ]);
            
            return response()->json(['success' => 'تم حذف اللجنة بنجاح!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف اللجنة: ' . $e->getMessage()], 500);
        }
    }
    

}
