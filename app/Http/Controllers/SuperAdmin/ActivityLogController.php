<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Activity_log;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('permissionMiddleware:read-activity_log,super_admin')->only('index');
    }
    public function index()
    {
        $activities = Activity_log::where('guard','super_admin')->get();
        return view('super_admin.activity_log.index', compact('activities'));
    }
}
