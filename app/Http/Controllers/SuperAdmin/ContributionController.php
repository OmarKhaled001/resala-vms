<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use Illuminate\Http\Request;

class ContributionController extends Controller
{
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
    
            return redirect()->back()->with('success', 'تم الإنشاء بنجاح!');
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

            return redirect()->back()->with('success', 'تم التحديث بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء التحديث: ' . $e->getMessage());
        }
    }

    public function destroyContribution($id)
    {
        try {
            Contribution::findOrFail($id)->delete();
    
            return response()->json(['success' => 'تم حذف المشاركة بنجاح!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف المشاركة: ' . $e->getMessage()], 500);
        }
    }
    
    
}
