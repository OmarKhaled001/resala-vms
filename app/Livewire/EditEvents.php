<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Section;
use Livewire\Component;
use App\Models\Volunteer;
use Illuminate\Support\Facades\DB;
use Spatie\LivewireFilepond\WithFilePond;
use Livewire\WithFileUploads;

class EditEvents extends Component
{
    use WithFilePond , WithFileUploads;
    public $event;
    public $files = [];
    public $sections = [];         
    public $section_id;             
    public $contributions = [];     
    public $contribution_id;       
    public $searchTerm = '';        
    public $selectedVolunteers = []; 
    public $selectedVolunteersShirts = []; 
    public $event_date;
    public $notes;
    public $newVolunteer = [
        'name' => '',
        'phone' => '',
        'vol_date' => '',
        'birth_date' => '',
        'gender' => '',
    ];
   
    public $images = []; 
    public $eventId = null; // معرف الحدث الذي يتم تعديله
    public $isEditing = false; // حالة التعديل

    public function mount()
    {
        $user = auth('volunteer')->user();
        $this->sections = $user->activity->sections;
        $this->selectedVolunteers = $this->event->volunteers->keyBy('id')->toArray(); // Convert to associative array
        $this->selectedVolunteersShirts = $this->event->volunteers->pluck('pivot')->keyBy('volunteer_id')->toArray();
        $this->notes = $this->event->notes;
        $this->event_date = $this->event->event_date;
        $this->section_id = $this->event->section_id;
        $this->contribution_id = $this->event->contribution_id;
    }


    public function updatedSectionId($value)
    {
        $section = Section::with('contributions')->find($value);
        $this->contributions = $section->contributions;
        $this->contribution_id = null; // إعادة تعيين المشاركة المختارة
    }

   
    public function selectVolunteer($volunteerId)
    {
        $volunteer = Volunteer::find($volunteerId);

        if ($volunteer) {
            $this->selectedVolunteers[$volunteerId] = $volunteer;
        }

        $this->reset('searchTerm');
    }

    public function removeVolunteer($volunteerId)
    {
        unset($this->selectedVolunteers[$volunteerId]);
    }


    public function editEvent($eventId)
    {
        $this->isEditing = true;
        $this->eventId = $eventId;

        // تحميل بيانات الحدث
        $event = Event::with('volunteers')->find($eventId);

        if ($event) {
            $this->event_date = $event->event_date;
            $this->section_id = $event->section_id;
            $this->contribution_id = $event->contribution_id;
            $this->notes = $event->notes;

            // تحميل المتطوعين المختارين
            $this->selectedVolunteers = $event->volunteers->pluck('pivot.tshirt', 'id')->toArray();
        }
    }

    public function updateEvent()
    {
        DB::beginTransaction();

        try {
            // تحديث الحدث
            $event = Event::find($this->eventId);

            if ($event) {
                $event->event_date = $this->event_date;
                $event->contribution_id = $this->contribution_id;
                $event->section_id = $this->section_id;
                $event->notes = $this->notes;
                $event->save();

                // تحديث المتطوعين المختارين
                $event->volunteers()->sync([]); // إزالة المتطوعين الحاليين
                foreach ($this->selectedVolunteers as $volunteerId => $volunteerData) {
                    $event->volunteers()->attach($volunteerId, [
                        'event_date' => $this->event_date,
                        'tshirt' => $this->selectedVolunteersShirts[$volunteerId]['tshirt'] ?? 0,
                    ]);
                }

                // تحديث الصور
                foreach ($this->files as $file) {
                    $event->addMedia($file->getRealPath())
                        ->toMediaCollection('images');
                }

                $this->reset('files');
            }

            DB::commit();
            $this->redirectRoute('volunteer.event.index');

            // إعادة تعيين الحقول
            $this->resetForm();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'حدث خطأ أثناء تحديث الحدث. يرجى المحاولة مرة أخرى.');
        }
    }

    public function resetForm()
    {
        $this->reset([
            'event_date',
            'section_id',
            'contribution_id',
            'notes',
            'selectedVolunteers',
            'selectedVolunteersShirts',
            'files',
            'eventId',
            'isEditing',
        ]);
    }

    public function addNewVolunteer()
    {
        $validatedData = $this->validate([
            'newVolunteer.name' => 'required|string|max:255|regex:/^[\pL\s]+$/u',
            'newVolunteer.phone' => 'required|string|regex:/^\+?\d{10,15}$/',
            'newVolunteer.vol_date' => 'required|date|before_or_equal:today',
            'newVolunteer.birth_date' => 'required|date|before:today',
            'newVolunteer.gender' => 'required|in:1,2',
        ],  [
            'newVolunteer.name.required' => 'يرجى إدخال الاسم الثلاثي.',
            'newVolunteer.name.regex' => 'الاسم يجب أن يحتوي على أحرف ومسافات فقط.',
            'newVolunteer.name.max' => 'الاسم يجب ألا يزيد عن 255 حرفًا.',
        
            'newVolunteer.phone.required' => 'يرجى إدخال رقم الهاتف.',
            'newVolunteer.phone.regex' => 'رقم الهاتف يجب أن يكون بصيغة صحيحة ولا يقل عن 11 رقم.',
            'newVolunteer.phone.unique' => 'رقم الهاتف مسجل مسبقًا.',
        
            'newVolunteer.vol_date.required' => 'يرجى إدخال تاريخ التطوع.',
            'newVolunteer.vol_date.date' => 'تاريخ التطوع غير صالح.',
            'newVolunteer.vol_date.before_or_equal' => 'تاريخ التطوع يجب أن يكون اليوم أو في الماضي.',
        
            'newVolunteer.birth_date.required' => 'يرجى إدخال تاريخ الميلاد.',
            'newVolunteer.birth_date.date' => 'تاريخ الميلاد غير صالح.',
            'newVolunteer.birth_date.before' => 'تاريخ الميلاد يجب أن يكون قبل اليوم.',
            'newVolunteer.birth_date.after_or_equal' => 'تاريخ الميلاد غير مقبول (قديم جدًا).',
        
            'newVolunteer.gender.required' => 'يرجى تحديد الجنس.',
            'newVolunteer.gender.in' => 'القيمة المختارة للجنس غير صالحة.',
            'newVolunteer.email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
            'newVolunteer.email.unique' => 'البريد الإلكتروني مسجل مسبقًا.',
        
        ]);

        $user = auth('volunteer')->user();

        $newVolunteer = Volunteer::create([
            'name' => $validatedData['newVolunteer']['name'],
            'phone' => $validatedData['newVolunteer']['phone'],
            'vol_date' => $validatedData['newVolunteer']['vol_date'],
            'birth_date' => $validatedData['newVolunteer']['birth_date'],
            'gender' => $validatedData['newVolunteer']['gender'],
            'branch_id' => $user->branch_id,
            'activity_id' => $user->activity_id,
            'type' => 'داخل المتابعة',
        ]);

        $this->selectedVolunteers[$newVolunteer->id] = $newVolunteer;
        $this->reset('newVolunteer');
        session()->flash('message', 'تمت إضافة المتطوع بنجاح.');
    }



    public function render()
    {
        $user = auth('volunteer')->user();
        $volunteers = $this->searchTerm
            ? Volunteer::where('branch_id', $user->branch_id)
                ->where('activity_id', $user->activity_id)
                ->where(function ($query) {
                    $query->where('name', 'LIKE', "%{$this->searchTerm}%")
                        ->orWhere('phone', 'LIKE', "%{$this->searchTerm}%")
                        ->orWhere('type', 'LIKE', "%{$this->searchTerm}%");
                })->whereNotIn('id', array_keys($this->selectedVolunteers))
                ->orderBy('name')
                ->limit(3)
                ->get()
            : null;

        return view('livewire.edit-events', compact('volunteers'));
    }
}
