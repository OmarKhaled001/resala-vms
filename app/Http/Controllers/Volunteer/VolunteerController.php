<?php

namespace App\Http\Controllers\Volunteer;

use App\Models\Volunteer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator; // Make sure this is imported
use Illuminate\Support\Facades\Auth; // Make sure this is imported if using auth()

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

    public function editVolunteer($id) {
        $user = auth('volunteer')->user();
        $sections = $user->activity->sections;
        $volunteer = Volunteer::find($id);
        return view('volunteer.vol.edit',compact('sections','volunteer'));

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
        // Validation rules
        $validator = Validator::make($request->all(), [
            'section_id' => 'nullable|exists:sections,id',
            // Ensures the name is at least three words
            'name' => 'required|string|min:3|regex:/^([\w\p{Arabic}]+[\s]){2}[\w\p{Arabic}]+$/u',
            'phone' => 'required|string|max:15', // Adjust phone number validation as per your requirements
            'gender' => 'required|in:1,2', // 1 for Male, 2 for Female
            'birth_date' => 'required|date',
            'vol_date' => 'required|date',
            'address' => 'nullable|string|max:255', // Added validation for address
            // Changed 'type' to nullable as it's conditional in the form
            'type' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'national' => 'nullable|string|max:255', // Added validation for national
            'tshirt' => 'nullable|boolean',
            'camp_48' => 'nullable|boolean',
            'mine_camp' => 'nullable|boolean',
            'notes' => 'nullable|string|max:500', // Added max length for notes
            'is_active' => 'nullable|boolean', // Added validation for is_active
            'profile_photos.*' => 'nullable|mimes:jpeg,png|max:10240', // Adjust as per your requirements
            'id_card' => 'nullable|mimes:jpeg,png|max:10240',
            'donation_receipts.*' => 'nullable|mimes:jpeg,png,pdf|max:10240',
            // Added validation for branch_id and activity_id if they might be in the request
            'branch_id' => 'nullable|exists:branches,id',
            'activity_id' => 'nullable|exists:activities,id',
        ], [
            // Custom error messages
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
            // Removed 'type.required' message as validation is now nullable
            'section_id.exists' => 'اللجنة المحددة غير موجودة',
            'branch_id.exists' => 'الفرع المحدد غير موجود',
            'activity_id.exists' => 'النشاط المحدد غير موجود',
            'profile_photos.*.mimes' => 'الصور الشخصية يجب أن تكون بصيغة JPEG أو PNG',
            'profile_photos.*.max' => 'الصور الشخصية يجب أن لا تتجاوز 10MB',
            'id_card.mimes' => 'صورة البطاقة يجب أن تكون بصيغة JPEG أو PNG',
            'id_card.max' => 'صورة البطاقة يجب أن لا تتجاوز 10MB',
            'donation_receipts.*.mimes' => 'إيصالات التبرع يجب أن تكون بصيغة JPEG أو PNG أو PDF',
            'donation_receipts.*.max' => 'إيصالات التبرع يجب أن لا تتجاوز 10MB',
        ]);

        // If validation fails, redirect back with errors and input
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Determine branch_id and activity_id
        // Check if a volunteer user is authenticated
        $user = Auth::guard('volunteer')->user();

        // Get branch_id and activity_id from authenticated user or request
        // If user is authenticated, use their branch/activity, otherwise use request data
        $branchId = $user ? $user->branch_id : $request->branch_id;
        $activityId = $user ? $user->activity_id : $request->activity_id;

        // Create a new Volunteer instance
        $volunteer = new Volunteer();

        // Assign attributes from the validated request data
        $volunteer->branch_id = $branchId;
        $volunteer->activity_id = $activityId;
        $volunteer->name = $request->name;
        $volunteer->phone = $request->phone;
        $volunteer->gender = $request->gender;
        $volunteer->birth_date = $request->birth_date;
        $volunteer->vol_date = $request->vol_date;
        // Use the value from the request or the default if not provided
        $volunteer->type = $request->type ?? 'داخل المتابعة';
        $volunteer->section_id = $request->section_id;
        $volunteer->position = $request->position;
        $volunteer->national = $request->national;
        $volunteer->address = $request->address;
        $volunteer->notes = $request->notes;

        // Assign boolean values, defaulting to false if not present in the request
        $volunteer->mine_camp = $request->boolean('mine_camp'); // Use boolean helper
        $volunteer->tshirt = $request->boolean('tshirt'); // Use boolean helper
        $volunteer->camp_48 = $request->boolean('camp_48'); // Use boolean helper
        // Default is_active to true if not present
        $volunteer->is_active = $request->boolean('is_active', true); // Use boolean helper with default

        // Save the volunteer model to the database
        $volunteer->save();

        // Handle file uploads using Spatie Media Library
        // Ensure Media Library is set up correctly in your project

        // Upload profile photos (multiple files)
        if ($request->hasFile('profile_photos')) {
            foreach ($request->file('profile_photos') as $file) {
                $volunteer->addMedia($file)->toMediaCollection('profile_photos');
            }
        }

        // Upload ID card (single file)
        if ($request->hasFile('id_card')) {
            // Clear existing id_card media before adding a new one if it's a single file field
            $volunteer->clearMediaCollection('id_card');
            $volunteer->addMedia($request->file('id_card'))->toMediaCollection('id_card');
        }

        // Upload donation receipts (multiple files)
        if ($request->hasFile('donation_receipts')) {
            foreach ($request->file('donation_receipts') as $file) {
                $volunteer->addMedia($file)->toMediaCollection('donation_receipts');
            }
        }

        // Redirect after successful storage
        return redirect()->route('volunteer.vol.index')->with('success', 'تم إضافة المتطوع بنجاح');
    }

    public function update(Request $request, Volunteer $volunteer)
    {
        // Validation rules - similar to store, but adjust if any fields are optional on update
        $validator = Validator::make($request->all(), [
            'section_id' => 'nullable|exists:sections,id',
            // Ensures the name is at least three words
            // Using 'sometimes' allows the field to be omitted if not being updated,
            // but if present, it must follow the rules.
            // If name is always required on update, remove 'sometimes'.
            'name' => 'sometimes|required|string|min:3|regex:/^([\w\p{Arabic}]+[\s]){2}[\w\p{Arabic}]+$/u',
            'phone' => 'sometimes|required|string|max:15', // Adjust phone number validation
            'gender' => 'sometimes|required|in:1,2', // 1 for Male, 2 for Female
            'birth_date' => 'sometimes|required|date',
            'vol_date' => 'sometimes|required|date',
            'address' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255', // Remains nullable
            'position' => 'nullable|string|max:255',
            'national' => 'nullable|string|max:255',
            'tshirt' => 'nullable|boolean',
            'camp_48' => 'nullable|boolean',
            'mine_camp' => 'nullable|boolean',
            'notes' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
            // File uploads are typically nullable on update as they might not be changed
            'profile_photos.*' => 'nullable|mimes:jpeg,png|max:10240',
            'id_card' => 'nullable|mimes:jpeg,png|max:10240',
            'donation_receipts.*' => 'nullable|mimes:jpeg,png,pdf|max:10240',
            // branch_id and activity_id validation
            'branch_id' => 'nullable|exists:branches,id',
            'activity_id' => 'nullable|exists:activities,id',
        ], [
            // Custom error messages (adjust as needed, some 'required' messages might not apply if using 'sometimes')
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
            'section_id.exists' => 'اللجنة المحددة غير موجودة',
            'branch_id.exists' => 'الفرع المحدد غير موجود',
            'activity_id.exists' => 'النشاط المحدد غير موجود',
            'profile_photos.*.mimes' => 'الصور الشخصية يجب أن تكون بصيغة JPEG أو PNG',
            'profile_photos.*.max' => 'الصور الشخصية يجب أن لا تتجاوز 10MB',
            'id_card.mimes' => 'صورة البطاقة يجب أن تكون بصيغة JPEG أو PNG',
            'id_card.max' => 'صورة البطاقة يجب أن لا تتجاوز 10MB',
            'donation_receipts.*.mimes' => 'إيصالات التبرع يجب أن تكون بصيغة JPEG أو PNG أو PDF',
            'donation_receipts.*.max' => 'إيصالات التبرع يجب أن لا تتجاوز 10MB',
        ]);

        // If validation fails, redirect back with errors and input
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Determine branch_id and activity_id if they are being updated or set
        // This logic might need adjustment based on how branch/activity are managed
        // If they are only set on creation, you might remove this part or make it conditional
        $user = Auth::guard('volunteer')->user();
        $branchId = $user ? $user->branch_id : $request->branch_id;
        $activityId = $user ? $user->activity_id : $request->activity_id;

        // Update the volunteer attributes from the validated request data
        // Use $request->input() or $request->get() with a default or check has()
        // to avoid overwriting with null if a field is not in the request (e.g., checkboxes)
        $volunteer->name = $request->input('name', $volunteer->name); // Only update if present
        $volunteer->phone = $request->input('phone', $volunteer->phone);
        $volunteer->gender = $request->input('gender', $volunteer->gender);
        $volunteer->birth_date = $request->input('birth_date', $volunteer->birth_date);
        $volunteer->vol_date = $request->input('vol_date', $volunteer->vol_date);
        $volunteer->address = $request->input('address', $volunteer->address);
        $volunteer->type = $request->input('type', $volunteer->type); // Update type if present
        $volunteer->section_id = $request->input('section_id', $volunteer->section_id);
        $volunteer->position = $request->input('position', $volunteer->position);
        $volunteer->national = $request->input('national', $volunteer->national);
        $volunteer->notes = $request->input('notes', $volunteer->notes);

        // Handle boolean fields explicitly as checkboxes are only in request if checked
        $volunteer->tshirt = $request->has('tshirt');
        $volunteer->mine_camp = $request->has('mine_camp');
        $volunteer->camp_48 = $request->has('camp_48');
        $volunteer->is_active = $request->has('is_active');


        // Update branch_id and activity_id if they are in the request
        if ($request->has('branch_id')) {
             $volunteer->branch_id = $request->branch_id;
        }
         if ($request->has('activity_id')) {
             $volunteer->activity_id = $request->activity_id;
        }
        // Alternatively, if branch_id/activity_id are determined by the authenticated user
        // and should NOT be updated via the form, remove the above two if blocks.


        // Save the updated volunteer model
        $volunteer->save();

        // Handle file uploads using Spatie Media Library
        // New files will replace existing ones for single file collections like 'id_card'
        // New files will be added to existing ones for multiple file collections

        // Upload profile photos (multiple files)
        if ($request->hasFile('profile_photos')) {
            // If you want to replace ALL profile photos, uncomment the next line
            // $volunteer->clearMediaCollection('profile_photos');
            foreach ($request->file('profile_photos') as $file) {
                $volunteer->addMedia($file)->toMediaCollection('profile_photos');
            }
        }

        // Upload ID card (single file)
        if ($request->hasFile('id_card')) {
            // Clear existing id_card media before adding a new one
            $volunteer->clearMediaCollection('id_card');
            $volunteer->addMedia($request->file('id_card'))->toMediaCollection('id_card');
        }

        // Upload donation receipts (multiple files)
        if ($request->hasFile('donation_receipts')) {
             // If you want to replace ALL donation receipts, uncomment the next line
            // $volunteer->clearMediaCollection('donation_receipts');
            foreach ($request->file('donation_receipts') as $file) {
                $volunteer->addMedia($file)->toMediaCollection('donation_receipts');
            }
        }

        // Redirect after successful update
        return redirect()->route('volunteer.vol.index')->with('success', 'تم تحديث بيانات المتطوع بنجاح');
    }

}
