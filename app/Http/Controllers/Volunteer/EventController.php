<?php

namespace App\Http\Controllers\Volunteer;

use App\Models\Event;
use App\Models\Branch;
use App\Models\Comment;
use App\Models\Section;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class EventController extends Controller
{

    
    public function index() {
        $user = auth('volunteer')->user();
        $sections = $user->activity->sections;

        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth = now()->endOfMonth()->toDateString();

        $events = Event::where('branch_id', $user->branch_id)
            ->where('activity_id', $user->activity_id)
            ->whereBetween('event_date', [$startOfMonth, $endOfMonth])
            ->with(['volunteers', 'contribution'])
            ->withCount([
                'volunteers',
                'volunteers as tshirt_count' => function ($query) {
                    $query->where('event_volunteer.tshirt', 1);
                },
            ])
        ->orderBy('event_date', 'desc')
        ->get();
        $volunteers =Volunteer::where('branch_id',$user->branch_id)->where('activity_id',$user->activity_id)->whereBetween('vol_date', [$startOfMonth, $endOfMonth]);

        $statistics = [
            'pending_count' => $events->where('status', 'pending')->count(),
            'conforming_count' => $events->where('status', 'conforming')->count(),
            'non_conforming_count' => $events->where('status', 'non-conforming')->count(),
            'rejected_count' => $events->where('status', 'rejected')->count(),
            'offline_count' => $events->filter(fn($event) => $event->contribution->value === 1)->count(),
            'online_count' => $events->filter(fn($event) => $event->contribution->value === 2)->count(),
            'total_volunteers_count' => $events->pluck('volunteers')->flatten()->count(),
            'unique_volunteers_count' => $events->pluck('volunteers')->flatten()->unique('id')->count(),
            'new_volunteers_count' =>  $volunteers->count(),
        ];

        return view('volunteer.event.index', compact('events', 'sections', 'statistics'));

        
    }
    
    
    public function eventFilter(Request $request) {
        $user = auth('volunteer')->user();
    
        // الحصول على البيانات المُدخلة
        $eventDateFrom = $request->input('event_date_from');
        $eventDateTo = $request->input('event_date_to');
        $sectionId = $request->input('section_id');
        $contributionId = $request->input('contribution_id');
        $status = $request->input('status');
        $volunteers =Volunteer::where('branch_id',$user->branch_id)->where('activity_id',$user->activity_id)->whereBetween('vol_date', [$eventDateFrom, $eventDateTo]);

        // بناء الاستعلام
        $events = Event::where('branch_id', $user->branch_id)
            ->where('activity_id', $user->activity_id)
            ->when($eventDateFrom, function ($query) use ($eventDateFrom) {
                $query->whereDate('event_date', '>=', $eventDateFrom);
            })
            ->when($eventDateTo, function ($query) use ($eventDateTo) {
                $query->whereDate('event_date', '<=', $eventDateTo);
            })
            ->when($sectionId, function ($query) use ($sectionId) {
                $query->where('section_id', $sectionId);
            })
            ->when($contributionId, function ($query) use ($contributionId) {
                $query->where('contribution_id', $contributionId);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->with('volunteers')
            ->withCount([
                'volunteers',
                'volunteers as tshirt_count' => function ($query) {
                    $query->where('event_volunteer.tshirt', 1);
                },
            ])
            ->orderBy('event_date', 'desc') // ترتيب من الأحدث إلى الأقدم
            ->get();
    
        $sections = $user->activity->sections;
        
        $statistics = [
            'pending_count' => $events->where('status', 'pending')->count(),
            'conforming_count' => $events->where('status', 'conforming')->count(),
            'non_conforming_count' => $events->where('status', 'non-conforming')->count(),
            'rejected_count' => $events->where('status', 'rejected')->count(),
            'offline_count' => $events->filter(fn($event) => $event->contribution->value === 1)->count(),
            'online_count' => $events->filter(fn($event) => $event->contribution->value === 2)->count(),
            'total_volunteers_count' => $events->pluck('volunteers')->flatten()->count(),
            'unique_volunteers_count' => $events->pluck('volunteers')->flatten()->unique('id')->count(),
            'new_volunteers_count' =>  $volunteers->count(),
        ];
        return view('volunteer.event.index', compact('events', 'sections','statistics'));
    }
    

    public function create() {
        $user = auth('volunteer')->user();
        $volunteers = Volunteer::where('branch_id',$user->branch_id)->where('activity_id',$user->activity_id)->get();
        $sections = $user->activity->sections;
        return view('volunteer.event.create',compact('volunteers','sections'));

    }

    public function edit($id) {
        $user = auth('volunteer')->user();
        $volunteers = Volunteer::where('branch_id',$user->branch_id)->where('activity_id',$user->activity_id)->get();
        $sections = $user->activity->sections;
        $event = Event::find($id);
        return view('volunteer.event.edit',compact('volunteers','sections','event'));

    }

   
    public function destroy(Request $request, $id)
    {
        $request->validate([
            '_token' => 'required',
        ]);
    
        try {
            $event = Event::findOrFail($id);
    
            if ($event->status != 'conforming') {
                $event->clearMediaCollection('images'); 
                $event->delete();
                return response()->json(['success' => 'تم حذف الحدث بنجاح.']);
            } else {
                return response()->json(['error' => 'لا يمكن حذف الحدث بسبب حالته الحالية.'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء محاولة حذف الحدث.'], 500);
        }
    }
    
    


    
}
