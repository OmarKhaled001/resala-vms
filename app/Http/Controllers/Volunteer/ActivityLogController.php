<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Activity_log;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activities = Activity_log::where('guard','volunteer')->get();
        return view('volunteer.activity_log.index', compact('activities'));
    }
}
