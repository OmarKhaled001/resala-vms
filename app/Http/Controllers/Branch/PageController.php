<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {


        $branch = auth()->guard('branch')->user();

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $monthlyEventsCount = $branch->events()
            ->whereBetween('event_date', [$startOfMonth, $endOfMonth])
            ->count();

        $pendingEventsCount = $branch->events()
            ->where('status', 'pending')
            ->whereBetween('event_date', [$startOfMonth, $endOfMonth])
            ->count();

        $conformingEventsCount = $branch->events()
            ->where('status', 'conforming')
            ->whereBetween('event_date', [$startOfMonth, $endOfMonth])
            ->count();

        return view('branch.index', [
            'statistics' => [
                'monthlyEvents' => $monthlyEventsCount,
                'pendingEvents' => $pendingEventsCount,
                'conformingEvents' => $conformingEventsCount,
            ],
        ]);
    }
}
