<?php

namespace App\Http\Controllers\volunteer;

use App\Models\Event;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PageController extends Controller
{
    
    public function index()
    {
        $user = auth('volunteer')->user();
        $sections = $user->activity->sections;
    
        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth = now()->endOfMonth()->toDateString();
    
        // جلب الأحداث لهذا الشهر
        $events = Event::where('branch_id', $user->branch_id)
            ->where('activity_id', $user->activity_id)
            ->whereBetween('event_date', [$startOfMonth, $endOfMonth])
            ->with(['volunteers', 'contribution'])
            ->orderBy('event_date', 'desc')
            ->get();
    
        // جلب جميع المتطوعين من نوع "مسئول" و "مشروع مسئول"
        $volunteersMasaol = Volunteer::where('branch_id', $user->branch_id)
            ->where('activity_id', $user->activity_id)
            ->where('type', 'مسئول')
            ->get();
    
        $volunteersMashroaaMasaol = Volunteer::where('branch_id', $user->branch_id)
            ->where('activity_id', $user->activity_id)
            ->where('type', 'مشروع مسئول')
            ->get();
    
        // حساب عدد المتطوعين من نوع "مسئول" و "مشروع مسئول"
        $volunteersMasaolCount = $volunteersMasaol->count();
        $volunteersMashroaaMasaolCount = $volunteersMashroaaMasaol->count();
    
        // عدد "مسئول" و "مشروع مسئول" الذين شاركوا في الأحداث
        $volunteersMasaolContributionCount = $volunteersMasaol->filter(function ($volunteer) use ($startOfMonth, $endOfMonth) {
            return $volunteer->events()->whereBetween('events.event_date', [$startOfMonth, $endOfMonth])->exists();
        })->count();
    
        $volunteersMashroaaMasaolContributionCount = $volunteersMashroaaMasaol->filter(function ($volunteer) use ($startOfMonth, $endOfMonth) {
            return $volunteer->events()->whereBetween('events.event_date', [$startOfMonth, $endOfMonth])->exists();
        })->count();
    
        // حساب النسب المئوية
        $masaolContributionPercentage = $volunteersMasaolCount > 0 
            ? ($volunteersMasaolContributionCount / $volunteersMasaolCount) * 100 
            : 0;
    
        $mashroaaMasaolContributionPercentage = $volunteersMashroaaMasaolCount > 0 
            ? ($volunteersMashroaaMasaolContributionCount / $volunteersMashroaaMasaolCount) * 100 
            : 0;
    
        // حساب المشاركات الشهرية الفعلية لكل متطوع مع الالتزام بالضوابط
        $masaolContributionSum = $volunteersMasaol->sum(function ($volunteer) {
            return $volunteer->getCappedMonthlyParticipationAttribute();
        });
    
        $mashroaaMasaolContributionSum = $volunteersMashroaaMasaol->sum(function ($volunteer) {
            return $volunteer->getCappedMonthlyParticipationAttribute();
        });
    
        $averagemasaolContribution = $volunteersMasaolCount > 0 ? round($masaolContributionSum / $volunteersMasaolCount, 2) : 0;
        $averagemashroaaMasaolContribution = $volunteersMashroaaMasaolCount > 0 ? round($mashroaaMasaolContributionSum / $volunteersMashroaaMasaolCount, 2) : 0;
    
        $volunteers = Volunteer::where('branch_id', $user->branch_id)
            ->where('activity_id', $user->activity_id)
            ->whereBetween('vol_date', [$startOfMonth, $endOfMonth]);
    
        $totalevents = $events->count();
        $conformingCount = $events->where('status', 'conforming')->count();
        $percentage = $totalevents > 0 ? ($conformingCount / $totalevents) * 100 : 0;
    
        $statistics = [
            'averagemasaolContribution' => $averagemasaolContribution,
            'averagemashroaaMasaolContribution' => $averagemashroaaMasaolContribution,
            'mashroaaMasaolContribution' => $mashroaaMasaolContributionSum,
            'masaolContributionPercentage' => round($masaolContributionPercentage, 2),
            'mashroaaMasaolContributionPercentage' => round($mashroaaMasaolContributionPercentage, 2),
            'volunteersMasaol_count' => $volunteersMasaolCount,
            'volunteersMashroaaMasaol_count' => $volunteersMashroaaMasaolCount,
            'volunteersMasaolContribution_count' => $volunteersMasaolContributionCount,
            'volunteersMashroaaMasaolContribution_count' => $volunteersMashroaaMasaolContributionCount,
            'pending_count' => $events->where('status', 'pending')->count(),
            'conforming_count' => $events->where('status', 'conforming')->count(),
            'non_conforming_count' => $events->where('status', 'non-conforming')->count(),
            'rejected_count' => $events->where('status', 'rejected')->count(),
            'offline_count' => $events->filter(fn($event) => $event->contribution->value === 1)->count(),
            'online_count' => $events->filter(fn($event) => $event->contribution->value === 2)->count(),
            'total_volunteers_count' => $events->pluck('volunteers')->flatten()->count(),
            'unique_volunteers_count' => $events->pluck('volunteers')->flatten()->unique('id')->count(),
            'new_volunteers_count' => $volunteers->count(),
        ];
    
        return view('volunteer.index', compact('statistics', 'percentage'));
    }
    

    public function getWeeklyVolunteerStatistics()
    {
        try {
            $user = auth('volunteer')->user();
            $startOfMonth = now()->startOfMonth()->toDateString();
            $endOfMonth = now()->endOfMonth()->toDateString();

            // Retrieve events for the current volunteer's branch and activity
            $events = Event::where('branch_id', $user->branch_id)
                ->where('activity_id', $user->activity_id)
                ->whereBetween('event_date', [$startOfMonth, $endOfMonth])
                ->with(['volunteers', 'contribution'])
                ->get();

            // Days of the week in Arabic (starting from Saturday to Friday)
            $days = [
                'Saturday' => 'السبت',
                'Sunday' => 'الأحد',
                'Monday' => 'الاثنين',
                'Tuesday' => 'الثلاثاء',
                'Wednesday' => 'الأربعاء',
                'Thursday' => 'الخميس',
                'Friday' => 'الجمعة',
            ];

            // Initialize statistics with zero for each day
            $statistics = collect($days)->mapWithKeys(fn($day) => [$day => ['offline_volunteers' => 0, 'online_volunteers' => 0]]);

            foreach ($events as $event) {
                $dayOfWeek = \Carbon\Carbon::parse($event->event_date)->format('l'); // English day name
                $arabicDay = $days[$dayOfWeek] ?? $dayOfWeek; // Translate to Arabic

                // Calculate offline and online volunteers
                $offlineVolunteers = $event->volunteers
                    ->filter(fn($volunteer) => $event->contribution->value === 1) // Offline contributions
                    ->unique('id')
                    ->count();

                $onlineVolunteers = $event->volunteers
                    ->filter(fn($volunteer) => $event->contribution->value === 2) // Online contributions
                    ->unique('id')
                    ->count();

                // Update statistics
                if (isset($statistics[$arabicDay])) {
                    // Use put() method to modify values in the collection
                    $statistics->put($arabicDay, [
                        'offline_volunteers' => $statistics[$arabicDay]['offline_volunteers'] + $offlineVolunteers,
                        'online_volunteers' => $statistics[$arabicDay]['online_volunteers'] + $onlineVolunteers
                    ]);
                }
            }

            // Reverse the days to show them in RTL order (from right to left)
            $reversedStatistics = $statistics->reverse();

            return response()->json([
                'days' => $reversedStatistics->keys()->toArray(),
                'offline' => $reversedStatistics->pluck('offline_volunteers')->toArray(),
                'online' => $reversedStatistics->pluck('online_volunteers')->toArray(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء جلب البيانات.'], 500);
        }
    }
}
