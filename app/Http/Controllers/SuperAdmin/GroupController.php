<?php

namespace App\Http\Controllers\SuperAdmin;

use Carbon\Carbon;
use App\Models\Group;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use App\Exports\FormatExport;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\ActivityLogsService;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    protected $ActivityLogsService;

    public function __construct(ActivityLogsService $ActivityLogsService)
    {
        $this->ActivityLogsService = $ActivityLogsService;

        $this->middleware('permissionMiddleware:read-group,super_admin')->only('allGroup');
        $this->middleware('permissionMiddleware:export-group,super_admin')->only('export');
    }
    public function allGroup()
    {
        $groups = Group::all();
        return view('super_admin.group.index', compact('groups'));
    }

    public function export(Request $request)
    {
        $ids = $request->input('ids');
        if (is_null($ids) || empty($ids)) {
            return back()->with('error', 'لم يتم تحديد أي بيانات.');
        }

        $idsArray = explode(',', $ids);
        $columns = $request->input('columns', []);

        $mainHeaders = [];
        $data = [];
        $groups = Group::whereIn('id', $idsArray)->get();
        $mainHeaders[] = '#';

        // headers
        if (in_array('name', $columns)) {
            $mainHeaders[] = 'اسم النشاط';
        }
        if (in_array('team_count', $columns)) {
            $mainHeaders[] = 'عدد الفريق';
        }
        if (in_array('team_countAttribute_count', $columns)) {
            $mainHeaders[] = 'فريق شارك';
        }
        if (in_array('masaol_count', $columns)) {
            $mainHeaders[] = 'عدد مسئول';
        }
        if (in_array('masaol_countAttribute_count', $columns)) {
            $mainHeaders[] = 'مسئول شارك';
        }
        if (in_array('masaol_countAttribute', $columns)) {
            $mainHeaders[] = 'متوسط مشاركات مسئول';
        }
        if (in_array('mashroaa_count', $columns)) {
            $mainHeaders[] = 'عدد مشروع مسئول';
        }

        if (in_array('mashroaa_countAttribute_count', $columns)) {
            $mainHeaders[] = 'مشروع مسئول شارك';
        }
        if (in_array('mashroaa_countAttribute', $columns)) {
            $mainHeaders[] = 'متوسط مشاركات مشروع مسئول';
        }
        if (in_array('new_count', $columns)) {
            $mainHeaders[] = 'الجدد';
        }


        // data
        foreach ($groups as $index => $group) {
            $row = [];
            $row[] =   $index + 1;
            if (in_array('name', $columns)) {
                $row[] = $group->name;
            }
            if (in_array('team_count', $columns)) {
                $row[] = ($group->getMasaolCount() + $group->getMashroaaMasaolCount()) ?? 0;
            }
            if (in_array('team_countAttribute_count', $columns)) {
                $row[] = ($group->getMasaolCountAttributeCount() + $group->getMashroaaMasaolCountAttributeCount()) ?? 0;
            }
            if (in_array('masaol_count', $columns)) {
                $row[] = $group->getMasaolCount() ?? 0;
            }
            if (in_array('masaol_countAttribute_count', $columns)) {
                $row[] = $group->getMasaolCountAttributeCount() ?? 0;
            }
            if (in_array('masaol_countAttribute', $columns)) {
                $row[] = $group->getMasaolCountAttribute() ?? 0;
            }
            if (in_array('mashroaa_count', $columns)) {
                $row[] = $group->getMashroaaMasaolCount() ?? 0;
            }
            if (in_array('mashroaa_countAttribute_count', $columns)) {
                $row[] = $group->getMashroaaMasaolCountAttributeCount() ?? 0;
            }

            if (in_array('mashroaa_countAttribute', $columns)) {
                $row[] = $group->getMashroaaMasaolCountAttribute() ?? 0;
            }
            if (in_array('new_count', $columns)) {
                $row[] = $group->getNewVolunteersCount() ?? 0;
            }

            $data[] = $row;
        }

        // name
        $monthName = Carbon::now()->locale('ar')->translatedFormat('F');
        $year = Carbon::now()->year;
        $fileName = 'تقرير الأنشطة شهر ' . $monthName . ' ' . $year . '.xlsx';

        return Excel::download(new FormatExport($mainHeaders, $data), $fileName);
    }

    public function addAdmin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'volunteer_id' => 'required|exists:volunteers,id',
                'username' => 'required|string|max:255|unique:volunteers,username,',
                'email' => 'required|email|max:255|unique:volunteers,email,',
                'password' => 'required|string|min:8|confirmed',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $volunteer = Volunteer::find($request->volunteer_id);
            $volunteer->is_admin = 1;
            $volunteer->username = $request->username;
            $volunteer->email = $request->email;
            $volunteer->password = bcrypt($request->password);
            $volunteer->save();
            
            $causer = auth('super_admin')->user();
            $this->ActivityLogsService->insert([
                'subject' => $volunteer,
                'causer' => $causer,
                'log_name' => 'تم تعين معلومات المتطوع: ' . $volunteer->name.'كمدير',
                'description' => 'تم تحديث معلومات المتطوع: ' . $volunteer->name . 
                ' (اسم المستخدم: ' . $volunteer->username . 
                ', البريد الإلكتروني: ' . $volunteer->email . 
                ') بتاريخ ' . now()->format('F j, Y g:i A'),
                'event' => 'تحديث',
                'guard' => 'super_admin',
            ]);
            
            return redirect()->back()->with('success', 'تم تحديث معلومات المتطوع بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء عملية الإنشاء: ' . $e->getMessage());
        }
    }
    
}
