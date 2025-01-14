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
        $validatedData = $request->validate();

        $section = new Section();
        $section->name = $validatedData['name'];
        $section->email = $validatedData['email'];
        $section->password = bcrypt($validatedData['password']); 
        $section->save();
        $section->contributions()->sync($validatedData['contribution_id']);

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
