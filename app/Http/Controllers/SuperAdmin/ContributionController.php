<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Contribution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ActivityLogsService;

class ContributionController extends Controller
{

    protected $ActivityLogsService;
    public function __construct(ActivityLogsService $ActivityLogsService)
    {
        $this->ActivityLogsService = $ActivityLogsService;
        $this->middleware('permissionMiddleware:read-contribution,super_admin')->only('allContribution');
        $this->middleware('permissionMiddleware:create-contribution,super_admin')->only('storeContribution');
        $this->middleware('permissionMiddleware:update-contribution,super_admin')->only('updateContribution');
        $this->middleware('permissionMiddleware:delete-contribution,super_admin')->only('destroyContribution');
    }
    
    public function allContribution()
    {
        $contributions = Contribution::all();
        return view('super_admin.contribution.index', compact('contributions'));
    }

    public function storeContribution(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'value' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'is_active' => 'nullable|boolean',
            ], [
                'name.required' => 'اسم المساهمة مطلوب.',
                'name.string' => 'اسم المساهمة يجب أن يكون نصًا.',
                'name.max' => 'اسم المساهمة يجب ألا يزيد عن 255 حرفًا.',
                'value.required' => 'قيمة المساهمة مطلوبة.',
                'value.numeric' => 'قيمة المساهمة يجب أن تكون رقمية.',
                'value.min' => 'قيمة المساهمة يجب ألا تكون سالبة.',
                'description.string' => 'الوصف يجب أن يكون نصًا.',
                'is_active.boolean' => 'حالة المساهمة يجب أن تكون صحيحة.',
            ]);
    
            $contribution = new Contribution();
            $contribution->name = $validatedData['name'];
            $contribution->value = $validatedData['value'];
            $contribution->description = $validatedData['description'];
            $contribution->is_active = $validatedData['is_active'] ?? 1;
            $contribution->save();
            $causer = auth('super_admin')->user();
            $this->ActivityLogsService->insert([
                'subject' => $contribution,
                'causer' => $causer,
                'log_name' => 'تم إضافة مساهمة جديدة: ' . $contribution->name,
                'description' => 'تم إنشاء المساهمة: ' . $contribution->name . ' من نوع: ' . $contribution-> getTypeLabel() . '، الحالة: ' . ($contribution->is_active ? 'نشطة' : 'غير نشطة') . ' بتاريخ ' . now()->format('F j, Y g:i A'),
                'event' => 'إضافة',
                'guard' => 'super_admin',
            ]);
            
            return redirect()->route('super_admin.contribution.index')->with('success', 'تم الإنشاء بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء الإنشاء: ' . $e->getMessage());
        }
    }

    public function updateContribution(Request $request)
    {
        // return response($request);
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'value' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'is_active' => 'nullable|boolean',
            ], [
                'name.required' => 'اسم المساهمة مطلوب.',
                'name.string' => 'اسم المساهمة يجب أن يكون نصًا.',
                'name.max' => 'اسم المساهمة يجب ألا يزيد عن 255 حرفًا.',
                'value.required' => 'قيمة المساهمة مطلوبة.',
                'value.numeric' => 'قيمة المساهمة يجب أن تكون رقمية.',
                'value.min' => 'قيمة المساهمة يجب ألا تكون سالبة.',
                'description.string' => 'الوصف يجب أن يكون نصًا.',
                'is_active.boolean' => 'حالة المساهمة يجب أن تكون صحيحة.',
            ]);

            $contribution = Contribution::findOrFail( $request->id);
            $contribution->name = $validatedData['name'];
            $contribution->value = $validatedData['value'];
            $contribution->description = $validatedData['description'];
            $contribution->is_active = $validatedData['is_active'] ?? 0;
            $contribution->save();
            $causer = auth('super_admin')->user();
            $this->ActivityLogsService->insert([
                'subject' => $contribution,
                'causer' => $causer,
                'log_name' => 'تم تعديل مساهمة: ' . $contribution->name,
                'description' => 'تم تعديل بيانات المساهمة: ' . $contribution->name . ' من نوع: ' . $contribution-> getTypeLabel() . '، الحالة: ' . ($contribution->is_active ? 'نشطة' : 'غير نشطة') . ' بتاريخ ' . now()->format('F j, Y g:i A'),
                'event' => 'تعديل',
                'guard' => 'super_admin',
            ]);
            
            return redirect()->route('super_admin.contribution.index')->with('success', 'تم التحديث بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء التحديث: ' . $e->getMessage());
        }
    }

    public function destroyContribution($id)
    {
        try {
            Contribution::findOrFail($id)->delete();
            $contribution = Contribution::findOrFail($id);
            $causer = auth('super_admin')->user();
            $this->ActivityLogsService->insert([
                'subject' => $contribution,
                'causer' => $causer,
                'log_name' => 'تم حذف مساهمة: ' . $contribution->name,
                'description' => 'تم حذف المساهمة: ' . $contribution->name . ' من نوع: ' . $contribution-> getTypeLabel() . '، الحالة: ' . ($contribution->is_active ? 'نشطة' : 'غير نشطة') . ' بتاريخ ' . now()->format('F j, Y g:i A'),
                'event' => 'حذف',
                'guard' => 'super_admin',
            ]);
            
            return response()->json(['success' => 'تم حذف المشاركة بنجاح!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف المشاركة: ' . $e->getMessage()], 500);
        }
    }
    
    
}
