<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Section;
use App\Models\Contribution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\SectionRequest;

class SectionController extends Controller
{
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
    
            return redirect()->route('super_admin.section.index')->with('success', 'تم الإنشاء بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء الإنشاء: ' . $e->getMessage());
        }
    }
    
    public function destroySection($id)
    {
        try {
            Section::findOrFail($id)->delete();
    
            return response()->json(['success' => 'تم حذف اللجنة بنجاح!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء حذف اللجنة: ' . $e->getMessage()], 500);
        }
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
