<?php

namespace App\Http\Controllers\Volunteer;

use App\Models\Volunteer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VolunteerController extends Controller
{

    public function allVolunteers()
    {
        $user = auth('volunteer')->user();
        $sections = $user->activity->sections;
        $volunteers = Volunteer::where('branch_id',$user->branch_id)
        ->where('activity_id',$user->activity_id)
        ->whereNotIn('type', ['مسئول', 'مشروع مسئول'])
        ->get();
        return view('volunteer.vol.index',compact('volunteers','sections'));

    }
    public function teemWork()
    {
        $user = auth('volunteer')->user();
        $sections = $user->activity->sections;
        $volunteers = Volunteer::where('branch_id',$user->branch_id)
        ->where('activity_id',$user->activity_id)
        ->whereIn('type', ['مسئول', 'مشروع مسئول'])
        ->orderBy('type', 'asc')
        ->get();
        return view('volunteer.vol.teem-work',compact('volunteers','sections'));

    }
    public function volunteerFilter(Request $request)
    {
        $user = auth('volunteer')->user();
        $sections = $user->activity->sections;
        $volunteers = Volunteer::where('branch_id',$user->branch_id)
        ->where('activity_id',$user->activity_id)->get();
        return view('volunteer.vol.index',compact('volunteers','sections'));

    }
    public function searchVolunteers(Request $request)
    {
        $searchTerm = $request->get('search_term');
        $type = $request->get('type');
        $user = auth('volunteer')->user(); // تأكد أنك تستخدم الحارس الصحيح
        
        $query = Volunteer::where('branch_id', $user->branch_id)
                          ->where('activity_id', $user->activity_id);

        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('phone', 'LIKE', "%{$searchTerm}%");
            });
        }

        if ($type) {
            $query->where('type', $type);
        }

        $volunteers = $query->orderBy('name')->limit(50)->get();

        return response()->json($volunteers);
    }

    public function createVolunteer() {
        $user = auth('volunteer')->user();
        $sections = $user->activity->sections;

        return view('volunteer.vol.create',compact('sections'));
        
    }

    public function shortStore(Request $request)
    {
        try {
            $user = auth('volunteer')->user();

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'gender' => 'required|in:1,2',
                'vol_date' => 'required|date',
                'birth_date' => 'required|date',
            ]);

            $newVolunteer = Volunteer::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'vol_date' => $validated['vol_date'], // تصحيح اسم الحقل
                'birth_date' => $validated['birth_date'],
                'gender' => $validated['gender'],
                'branch_id' => $user->branch_id,
                'activity_id' => $user->activity_id,
                'type' => 'داخل المتابعة',
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'تم إضافة المتطوع بنجاح!',
                'volunteer' => $newVolunteer,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء إضافة المتطوع. يرجى المحاولة مرة أخرى.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    

    

}
