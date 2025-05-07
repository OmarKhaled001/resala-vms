<?php

namespace App\Http\Controllers\Volunteer;

use App\Models\Volunteer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VolunteerController extends Controller
{

    public function allVolunteers()
    {
        $user = auth('volunteer')->user();
        $sections = $user->activity->sections;
        $volunteers = Volunteer::where('branch_id',$user->branch_id)
        ->where('activity_id',$user->activity_id)
        ->whereNotIn('type', ['مسئول', 'مشروع مسئول'])
        ->get();
        return view('volunteer.vol.index',compact('volunteers','sections'));

    }
    public function teemWork()
    {
        $user = auth('volunteer')->user();
        $sections = $user->activity->sections;
        $volunteers = Volunteer::where('branch_id',$user->branch_id)
        ->where('activity_id',$user->activity_id)
        ->whereIn('type', ['مسئول', 'مشروع مسئول'])
        ->orderBy('type', 'asc')
        ->get();
        return view('volunteer.vol.teem-work',compact('volunteers','sections'));

    }
    public function volunteerFilter(Request $request)
    {
        $user = auth('volunteer')->user();
        $sections = $user->activity->sections;
        $volunteers = Volunteer::where('branch_id',$user->branch_id)
        ->where('activity_id',$user->activity_id)->get();
        return view('volunteer.vol.index',compact('volunteers','sections'));

    }
    public function searchVolunteers(Request $request)
    {
        $searchTerm = $request->get('search_term');
        $type = $request->get('type');
        $user = auth('volunteer')->user(); // تأكد أنك تستخدم الحارس الصحيح

        $query = Volunteer::where('branch_id', $user->branch_id)
                          ->where('activity_id', $user->activity_id);

        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('phone', 'LIKE', "%{$searchTerm}%");
            });
        }

        if ($type) {
            $query->where('type', $type);
        }

        $volunteers = $query->orderBy('name')->limit(50)->get();

        return response()->json($volunteers);
    }

    public function createVolunteer() {
        $user = auth('volunteer')->user();
        $sections = $user->activity->sections;

        return view('volunteer.vol.create',compact('sections'));

    }

    public function shortStore(Request $request)
    {
        try {
            $user = auth('volunteer')->user();

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'gender' => 'required|in:1,2',
                'vol_date' => 'required|date',
                'birth_date' => 'required|date',
            ]);

            $newVolunteer = Volunteer::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'vol_date' => $validated['vol_date'], // تصحيح اسم الحقل
                'birth_date' => $validated['birth_date'],
                'gender' => $validated['gender'],
                'branch_id' => $user->branch_id,
                'activity_id' => $user->activity_id,
                'type' => 'داخل المتابعة',
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'تم إضافة المتطوع بنجاح!',
                'volunteer' => $newVolunteer,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء إضافة المتطوع. يرجى المحاولة مرة أخرى.',
                'error' => $e->getMessage(),
            ], 500);
        }


    }




    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|regex:/^([\w]+[\s]){2}[\w]+$/u', // Ensures the name is at least three words
            'phone' => 'required|string|max:15', // Adjust phone number validation as per your requirements
            'gender' => 'required|in:1,2', // 1 for Male, 2 for Female
            'birth_date' => 'required|date',
            'vol_date' => 'required|date',
            'type' => 'required|string',
            'section_id' => 'nullable|exists:sections,id', // Assuming 'sections' is a valid table
            'position' => 'nullable|string',
            'tshirt' => 'nullable|boolean',
            'camp_48' => 'nullable|boolean',
            'mine_camp' => 'nullable|boolean',
            'notes' => 'nullable|string',
            'profile_photos.*' => 'nullable|mimes:jpeg,png|max:10240', // Adjust as per your requirements
            'id_card' => 'nullable|mimes:jpeg,png|max:10240',
            'donation_receipts.*' => 'nullable|mimes:jpeg,png,pdf|max:10240',
        ], [
            'name.required' => 'اسم المتطوع مطلوب',
            'name.regex' => 'يجب أن يكون الاسم ثلاثي (يتألف من ثلاثة أجزاء)',
            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.max' => 'رقم الهاتف يجب أن لا يتجاوز 15 حرفًا',
            'gender.required' => 'النوع مطلوب',
            'gender.in' => 'النوع غير صحيح',
            'birth_date.required' => 'تاريخ الميلاد مطلوب',
            'birth_date.date' => 'تاريخ الميلاد يجب أن يكون بتاريخ صحيح',
            'vol_date.required' => 'تاريخ التطوع مطلوب',
            'vol_date.date' => 'تاريخ التطوع يجب أن يكون بتاريخ صحيح',
            'type.required' => 'النوع مطلوب',
            'section_id.exists' => 'اللجنة المحددة غير موجودة',
            'profile_photos.*.mimes' => 'الصور الشخصية يجب أن تكون بصيغة JPEG أو PNG',
            'profile_photos.*.max' => 'الصور الشخصية يجب أن لا تتجاوز 10MB',
            'id_card.mimes' => 'صورة البطاقة يجب أن تكون بصيغة JPEG أو PNG',
            'id_card.max' => 'صورة البطاقة يجب أن لا تتجاوز 10MB',
            'donation_receipts.*.mimes' => 'إيصالات التبرع يجب أن تكون بصيغة JPEG أو PNG أو PDF',
            'donation_receipts.*.max' => 'إيصالات التبرع يجب أن لا تتجاوز 10MB',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Store the volunteer
        $volunteer = new Volunteer();
        $volunteer->name = $request->name;
        $volunteer->phone = $request->phone;
        $volunteer->gender = $request->gender;
        $volunteer->birth_date = $request->birth_date;
        $volunteer->vol_date = $request->vol_date;
        $volunteer->type = $request->type;
        $volunteer->section_id = $request->section_id;
        $volunteer->position = $request->position;
        $volunteer->notes = $request->notes;
        $volunteer->mine_camp = $request->mine_camp;
        $volunteer->tshirt = $request->tshirt;
        $volunteer->camp_48 = $request->camp_48;

        // Handle file uploads
        if ($request->hasFile('profile_photos')) {
            foreach ($request->file('profile_photos') as $file) {
                $volunteer->addMedia($file)->toMediaCollection('profile_photos');
            }
        }

        if ($request->hasFile('id_card')) {
            foreach ($request->file('id_card') as $file) {
                $volunteer->addMedia($file)->toMediaCollection('id_card');
            }
        }

        if ($request->hasFile('donation_receipts')) {
            foreach ($request->file('donation_receipts') as $file) {
                $volunteer->addMedia($file)->toMediaCollection('donation_receipts');
            }
        }

        $volunteer->save();

        return redirect()->route('volunteers.index')->with('success', 'تم إضافة المتطوع بنجاح');
    }

    public function update(Request $request, Volunteer $volunteer)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|regex:/^([\w]+[\s]){2}[\w]+$/u', // Ensures the name is at least three words
            'phone' => 'required|string|max:15',
            'gender' => 'required|in:1,2',
            'birth_date' => 'required|date',
            'vol_date' => 'required|date',
            'type' => 'required|string',
            'section_id' => 'nullable|exists:sections,id',
            'position' => 'nullable|string',
            'tshirt' => 'nullable|boolean',
            'camp_48' => 'nullable|boolean',
            'mine_camp' => 'nullable|boolean',
            'notes' => 'nullable|string',
            'profile_photos.*' => 'nullable|mimes:jpeg,png|max:10240',
            'id_card' => 'nullable|mimes:jpeg,png|max:10240',
            'donation_receipts.*' => 'nullable|mimes:jpeg,png,pdf|max:10240',
        ], [
            'name.required' => 'اسم المتطوع مطلوب',
            'name.regex' => 'يجب أن يكون الاسم ثلاثي (يتألف من ثلاثة أجزاء)',
            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.max' => 'رقم الهاتف يجب أن لا يتجاوز 15 حرفًا',
            'gender.required' => 'النوع مطلوب',
            'gender.in' => 'النوع غير صحيح',
            'birth_date.required' => 'تاريخ الميلاد مطلوب',
            'birth_date.date' => 'تاريخ الميلاد يجب أن يكون بتاريخ صحيح',
            'vol_date.required' => 'تاريخ التطوع مطلوب',
            'vol_date.date' => 'تاريخ التطوع يجب أن يكون بتاريخ صحيح',
            'type.required' => 'النوع مطلوب',
            'section_id.exists' => 'اللجنة المحددة غير موجودة',
            'profile_photos.*.mimes' => 'الصور الشخصية يجب أن تكون بصيغة JPEG أو PNG',
            'profile_photos.*.max' => 'الصور الشخصية يجب أن لا تتجاوز 10MB',
            'id_card.mimes' => 'صورة البطاقة يجب أن تكون بصيغة JPEG أو PNG',
            'id_card.max' => 'صورة البطاقة يجب أن لا تتجاوز 10MB',
            'donation_receipts.*.mimes' => 'إيصالات التبرع يجب أن تكون بصيغة JPEG أو PNG أو PDF',
            'donation_receipts.*.max' => 'إيصالات التبرع يجب أن لا تتجاوز 10MB',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Update the volunteer
        $volunteer->name = $request->name;
        $volunteer->phone = $request->phone;
        $volunteer->gender = $request->gender;
        $volunteer->birth_date = $request->birth_date;
        $volunteer->vol_date = $request->vol_date;
        $volunteer->type = $request->type;
        $volunteer->section_id = $request->section_id;
        $volunteer->position = $request->position;
        $volunteer->notes = $request->notes;
        $volunteer->mine_camp = $request->mine_camp;
        $volunteer->tshirt = $request->tshirt;
        $volunteer->camp_48 = $request->camp_48;

        // Handle file uploads
        if ($request->hasFile('profile_photos')) {
            foreach ($request->file('profile_photos') as $file) {
                $volunteer->addMedia($file)->toMediaCollection('profile_photos');
            }
        }

        if ($request->hasFile('id_card')) {
            foreach ($request->file('id_card') as $file) {
                $volunteer->addMedia($file)->toMediaCollection('id_card');
            }
        }

        if ($request->hasFile('donation_receipts')) {
            foreach ($request->file('donation_receipts') as $file) {
                $volunteer->addMedia($file)->toMediaCollection('donation_receipts');
            }
        }
        $volunteer->save();

        return redirect()->route('volunteers.index')->with('success', 'تم تعديل بيانات المتطوع بنجاح');
    }

}
