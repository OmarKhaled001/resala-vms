<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Branch;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\BranchRequest;
use App\Models\Activity;

class BranchController extends Controller
{
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
    
            $branch->activities()->sync($validatedData['activity_id']);
    
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
    
            $branch->activities()->sync($validatedData['activity_id']);
    
            return redirect()->route('super_admin.branch.index')->with('success', 'تم الإنشاء بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء الإنشاء: ' . $e->getMessage());
        }
    }
    
    public function destroyBranch($id)
    {
        try {
            Branch::findOrFail($id)->delete();
    
            return response()->json(['success' => 'تم حذف اللجنة بنجاح!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف اللجنة: ' . $e->getMessage()], 500);
        }
    }
    

}
