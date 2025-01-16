<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Activity_log;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activities = Activity_log::where('guard','super_admin')->get();
        return view('super_admin.activity_log.index', compact('activities'));
    }
}
