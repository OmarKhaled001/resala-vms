<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Section;
use App\Models\Contribution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ActivityLogsService;
use App\Http\Requests\SuperAdmin\SectionRequest;

class SectionController extends Controller
{

    protected $ActivityLogsService;
    public function __construct(ActivityLogsService $ActivityLogsService)
    {
        $this->ActivityLogsService = $ActivityLogsService;
        $this->middleware('permissionMiddleware:read-section,super_admin')->only('allSection');
        $this->middleware('permissionMiddleware:create-section,super_admin')->only('createForm');
        $this->middleware('permissionMiddleware:create-section,super_admin')->only('storeSection');
        $this->middleware('permissionMiddleware:update-section,super_admin')->only('editForm');
        $this->middleware('permissionMiddleware:update-section,super_admin')->only('updateSection');
        $this->middleware('permissionMiddleware:delete-section,super_admin')->only('destroySection');
    }
    
    public function allSection() 
    {
        $sections = Section::all();
        return view('super_admin.section.index',compact('sections'));
        
    }

    public function createForm() 
    {
        $contributions = Contribution::all();
        return view('super_admin.section.create', compact('contributions'));
        
    }

    public function editForm($id) 
    {
        $section = Section::find($id);
        $contributions = Contribution::all();
        return view('super_admin.section.edit', compact('section','contributions'));
        
    }

    public function storeSection(SectionRequest $request)
    {
        try {
            $validatedData = $request->validated();
    
            $section =  new Section();
            $section->name = $validatedData['name'];
            $section->description = $validatedData['description'] ?? null;
            $section->username = $validatedData['username'] ;
            $section->email = $validatedData['email'] ;
            $section->password = bcrypt($validatedData['password']) ?? bcrypt($validatedData['username']) ;
            $section->save();
            $section->contributions()->sync($validatedData['contribution_id']);
            $causer = auth('super_admin')->user();
            $this->ActivityLogsService->insert([
                'subject' => $section,
                'causer' => $causer,
                'log_name' => 'تم إضافة قسم جديد: ' . $section->name,
                'description' => 'تم إنشاء القسم: ' . $section->name . ' (اسم المستخدم: ' . $section->username . ', البريد الإلكتروني: ' . $section->email . ') بتاريخ ' . now()->format('F j, Y g:i A'),
                'event' => 'إضافة',
                'guard' => 'super_admin',
            ]);
            
            return redirect()->route('super_admin.section.index')->with('success', 'تم الإنشاء بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء الإنشاء: ' . $e->getMessage());
        }
    }

    public function updateSection(SectionRequest $request)
    {
        try {
            $validatedData = $request->validated();
    
            $section = Section::find($request->id) ;
            $section->name = $validatedData['name'];
            $section->description = $validatedData['description'] ?? null;
            $section->username = $validatedData['username'];
            $section->email = $validatedData['email'];
    
            if (!empty($validatedData['password'])) {
                $section->password = bcrypt($validatedData['password']);
            }
    
            $section->save();
    
            $section->contributions()->sync($validatedData['contribution_id']);
            $causer = auth('super_admin')->user();
            $this->ActivityLogsService->insert([
                'subject' => $section,
                'causer' => $causer,
                'log_name' => 'تم تعديل قسم: ' . $section->name,
                'description' => 'تم تعديل بيانات القسم: ' . $section->name . ' (اسم المستخدم: ' . $section->username . ', البريد الإلكتروني: ' . $section->email . ') بتاريخ ' . now()->format('F j, Y g:i A'),
                'event' => 'تعديل',
                'guard' => 'super_admin',
            ]);
            
            return redirect()->route('super_admin.section.index')->with('success', 'تم الإنشاء بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء الإنشاء: ' . $e->getMessage());
        }
    }
    
    public function destroySection($id)
    {
        try {
            Section::findOrFail($id)->delete();
            $section = Section::findOrFail($id);
            $causer = auth('super_admin')->user();
            $this->ActivityLogsService->insert([
                'subject' => $section,
                'causer' => $causer,
                'log_name' => 'تم حذف قسم: ' . $section->name,
                'description' => 'تم حذف بيانات القسم: ' . $section->name . ' (اسم المستخدم: ' . $section->username . ', البريد الإلكتروني: ' . $section->email . ') بتاريخ ' . now()->format('F j, Y g:i A'),
                'event' => 'حذف',
                'guard' => 'super_admin',
            ]);
            
            return response()->json(['success' => 'تم حذف اللجنة بنجاح!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف اللجنة: ' . $e->getMessage()], 500);
        }
    }
    
    
}
