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

    public function createMedia($id) {
        $event = Event::find($id);
        $user = auth('volunteer')->user();
        $volunteers = Volunteer::where('branch_id',$user->branch_id)->where('activity_id',$user->activity_id)->get();
        $sections = $user->activity->sections;
        return view('volunteer.event.create-media',compact('volunteers','sections','event'));
    }

    public function storeMedia(Request $request) {

        // return response( $request);

        $messages = [
            'id.required' => 'حقل الحدث مطلوب.',
            'id.exists' => 'الحدث الذي تم تحديده غير موجود.',
            'images.required' => 'يجب رفع صور للحدث.',
            'images.*.file' => 'كل صورة يجب أن تكون ملفًا.',
            'images.*.image' => 'كل صورة يجب أن تكون صورة.',
            'images.*.max' => 'يجب أن لا يتجاوز حجم الصورة 5 ميجابايت.',
        ];
        $request->validate([
            'id' => 'required|exists:events,id',
            'images' => 'required|array',
            'images.*' => 'file|image|max:5120', // Max size 5 MB per file
        ], $messages);
        $event = Event::find($request->id);
    
        if ($request->images && count($request->images) > 0) {
            foreach ($request->images as $image) {
                $event->addMedia($image)->toMediaCollection('events');
            }
            return redirect()->route('volunteer.event.index')->with('success', 'تم إضافة الحدث بنجاح!');
        } else {
            return back()->withErrors(['images' => 'فشل في رفع الصور!'])->withInput();
        }
    }

    public function storeComment(Request $request, Event $event)
    {
 
        $request->validate([
            'body' => 'required|string',
            'commentable_id' => 'required|integer',
            'commentable_type' => 'required|string',
        ]);

        $comment = Comment::create([
            'body' => $request->body,
            'commentable_id' => $request->commentable_id,
            'commentable_type' => $request->commentable_type,
            'authorable_id' => auth('volunteer')->user()->id,
            'authorable_type' => auth('volunteer')->user()::class,
        ]);

        return response()->json(['success' => true, 'comment' => $comment]);
    }
    
    public function destroy(Request $request, $id)
    {
        $request->validate([
            '_token' => 'required',
        ]);
    
        try {
            $event = Event::findOrFail($id);
    
            if ($event->status != 'conforming') {
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
