<?php

namespace App\Http\Controllers\Branch;

use App\Models\Event;
use App\Models\Branch;
use App\Models\Section;
use App\Models\Activity;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class EventController extends Controller
{

    public function getEventsByActivity($activity_id) {
        $user = auth('branch')->user();
        $activity = Activity::find($activity_id);
        $sections = $activity->sections;
        $events = Event::where('branch_id', $user->id)
        ->where('activity_id', $activity_id)
        ->with('volunteers')
        ->withCount([
            'volunteers',
            'volunteers as tshirt_count' => function ($query) {
                $query->where('event_volunteer.tshirt', 1); 
            },
        ])
        ->get();
        return view('branch.event.index',compact('events','sections','activity'));
    }

    public function changeEventStatus(Request $request ,$event_id) {
        $event = Event::find($event_id);
        $event->status = $request->status ;
        $event->reason = $request->reason ;
        $event->save();
        return redirect()->back()->with('success', 'تم تغير الحالة بنجاح!');
    }
    
    public function create() {
        $user = auth('volunteer')->user();
        $volunteers = Volunteer::where('branch_id',$user->branch_id)->where('activity_id',$user->activity_id)->get();
        $sections = $user->activity->sections;
        return view('volunteer.event.create',compact('volunteers','sections'));

    }
    public function store(Request $request)
    {
        $user = auth('volunteer')->user();
    
        $validatedData = $request->validate([
            'event_date' => 'required|date_format:d/m/Y',
            'section_id' => 'required|exists:sections,id',
            'contribution_id' => 'required|exists:contributions,id',
            'volunteer_ids' => 'required|array',
            'volunteer_ids.*' => 'exists:volunteers,id',
            'notes' => 'nullable|string|max:1000',
        ], [
            'event_date.required' => 'يرجى إدخال تاريخ الحدث.',
            'event_date.date_format' => 'تنسيق تاريخ الحدث غير صحيح.',
            'section_id.required' => 'يرجى اختيار اللجنة.',
            'section_id.exists' => 'اللجنة المختارة غير موجودة.',
            'contribution_id.required' => 'يرجى اختيار المشاركة.',
            'contribution_id.exists' => 'المشاركة المختارة غير موجودة.',
            'volunteer_ids.required' => 'يرجى اختيار المتطوعين.',
            'volunteer_ids.*.exists' => 'أحد المتطوعين المختارين غير موجود.',
            'notes.string' => 'الملاحظات يجب أن تكون نصاً.',
            'notes.max' => 'الملاحظات يجب ألا تتجاوز 1000 حرف.',
        ]);
    
        try {
            $event = Event::create([
                'event_date' => Carbon::createFromFormat('d/m/Y', $request->event_date)->format('Y-m-d'),
                'branch_id' => $user->branch->id,
                'activity_id' => $user->activity->id,
                'section_id' => $request->section_id,
                'contribution_id' => $request->contribution_id,
                'notes' => $request->notes,
                'status' => 'pending',
            ]);
    
            $volunteers = [];
            foreach ($validatedData['volunteer_ids'] as $volunteerId) {
                $volunteers[$volunteerId] = [
                    'event_date' => Carbon::createFromFormat('d/m/Y', $request->event_date)->format('Y-m-d'), 
                ];
            }
    
            $event->volunteers()->sync($volunteers);
    
            return redirect()->back()->with('success', 'تم إضافة الحدث بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة الحدث. يرجى المحاولة لاحقاً.');
        }
    }
    

    
}
