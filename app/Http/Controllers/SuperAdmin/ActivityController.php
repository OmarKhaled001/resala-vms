<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Section;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Exports\FormatExport;
use Illuminate\Support\Carbon;
use App\Imports\ActivityImport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SuperAdmin\ActivityRequest;

class ActivityController extends Controller
{
    public function allActivity()
    {
        $activities = Activity::all();
        return view('super_admin.activity.index', compact('activities'));
    }
    public function createForm()
    {
        $sections = Section::all();
        return view('super_admin.activity.create', compact('sections'));
    }

    public function storeActivity(ActivityRequest $request)
    {
        try {
            $validatedData = $request->validated(); 
    
            $activity = new Activity();
            $activity->name = $validatedData['name'];
            $activity->username = $validatedData['username'];
            $activity->email = $validatedData['email'];
            $activity->password = bcrypt($validatedData['password']);
            $activity->save();
    
            $activity->sections()->sync($validatedData['section_id']);
    
            return redirect()->route('super_admin.activity.index')->with('success', 'تم الإنشاء بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء عملية الإنشاء: ' . $e->getMessage());
        }
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
        $activities = Activity::whereIn('id', $idsArray)->get();
        $mainHeaders[] = '#';

        // headers
        if (in_array('name', $columns)) {
            $mainHeaders[] = 'اسم النشاط';
        }
        if (in_array('username', $columns)) {
            $mainHeaders[] = 'اسم المستخدم';
        }
        if (in_array('email', $columns)) {
            $mainHeaders[] = 'البريد الالكتروني';
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
        foreach ($activities as $index => $activity) {
            $row = [];
            $row[] =   $index + 1;
            if (in_array('name', $columns)) {
                $row[] = $activity->name;
            }
            if (in_array('username', $columns)) {
                $row[] = $activity->username;
            }
            if (in_array('email', $columns)) {
                $row[] = $activity->email;
            }
            if (in_array('team_count', $columns)) {
                $row[] = ($activity->getMasaolCount() + $activity->getMashroaaMasaolCount()) ?? 0;
            }
            if (in_array('team_countAttribute_count', $columns)) {
                $row[] = ($activity->getMasaolCountAttributeCount() + $activity->getMashroaaMasaolCountAttributeCount()) ?? 0;
            }
            if (in_array('masaol_count', $columns)) {
                $row[] = $activity->getMasaolCount() ?? 0;
            }
            if (in_array('masaol_countAttribute_count', $columns)) {
                $row[] = $activity->getMasaolCountAttributeCount() ?? 0;
            }
            if (in_array('masaol_countAttribute', $columns)) {
                $row[] = $activity->getMasaolCountAttribute() ?? 0;
            }
            if (in_array('mashroaa_count', $columns)) {
                $row[] = $activity->getMashroaaMasaolCount() ?? 0;
            }
            if (in_array('mashroaa_countAttribute_count', $columns)) {
                $row[] = $activity->getMashroaaMasaolCountAttributeCount() ?? 0;
            }

            if (in_array('mashroaa_countAttribute', $columns)) {
                $row[] = $activity->getMashroaaMasaolCountAttribute() ?? 0;
            }
            if (in_array('new_count', $columns)) {
                $row[] = $activity->getNewVolunteersCount() ?? 0;
            }

            $data[] = $row;
        }

        // name
        $monthName = Carbon::now()->locale('ar')->translatedFormat('F');
        $year = Carbon::now()->year;
        $fileName = 'تقرير الأنشطة شهر ' . $monthName . ' ' . $year . '.xlsx';

        return Excel::download(new FormatExport($mainHeaders, $data), $fileName);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240', // Validate file type and size
        ]);

        try {
            $filePath = $request->file('file')->store('temp'); // Temporarily store the file
            $fullPath = storage_path('app/' . $filePath);

            Excel::import(new ActivityImport, $fullPath);

            return back()->with('success', 'تم استيراد الأنشطة بنجاح!');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء استيراد الملف: ' . $e->getMessage());
        }
    }

    public function deleteActivity($id)
    {
        try {
            Activity::findOrFail($id)->delete();
            return redirect()->back()->with('success', 'تم حذف النشاط بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف النشاط: ' . $e->getMessage());
        }
    }

    public function deleteActivities(Request $request)
    {
        $activityIds = explode(',', $request->input('activity_ids'));
    
        $validated = $request->validate([
            'activity_ids' => 'required|string', 
            'activity_ids.*' => 'exists:activities,id', 
        ], [
            'activity_ids.required' => 'يجب اختيار الأنشطة التي تريد حذفها.',
            'activity_ids.*.exists' => 'أحد الأنشطة المختارة غير موجود في النظام.',
        ]);
    
        try {
            Activity::whereIn('id', $activityIds)->delete();
            return redirect()->back()->with('success', 'تم حذف الأنشطة بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف الأنشطة: ' . $e->getMessage());
        }
    }
    
    public function editForm($id)
    {
        $activity = Activity::findOrFail($id);
        $sections = Section::all();

        return view('super_admin.activity.edit', compact('activity', 'sections'));
    }

    public function updateActivity(ActivityRequest $request)
    {
        try {
            $validatedData = $request->validated();
    
            $activity = Activity::findOrFail($request->id);
            $activity->name = $validatedData['name'];
            $activity->username = $validatedData['username'];
            $activity->email = $validatedData['email'];
    
            if (!empty($validatedData['password'])) {
                $activity->password = bcrypt($validatedData['password']);
            }
    
            $activity->save();
            $activity->sections()->sync($validatedData['section_id']);
    
            return redirect()->route('super_admin.activity.index')->with('success', 'تم التعديل بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء عملية التعديل: ' . $e->getMessage());
        }
    }
    

    public function sheet()
    {
        $filePath = public_path('sheets/نموذج الانشطة.xlsx');

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return back()->with('error', 'الملف غير موجود.');
        }
    }
}

