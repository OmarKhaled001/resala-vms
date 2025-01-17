<?php

namespace App\Http\Controllers\SuperAdmin;

use Carbon\Carbon;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Exports\FormatExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class GroupController extends Controller
{
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

}
