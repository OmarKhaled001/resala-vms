<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Section;
use Livewire\Component;
use App\Models\Volunteer;
use Illuminate\Support\Facades\DB;

class EditEvents extends Component
{
    public $event;
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
        $this->contribution_id = null;
    }

    public function addNewVolunteer()
    {
        $validatedData = $this->validate([
            'newVolunteer.name' => 'required|string|max:255|regex:/^[\pL\s]+$/u',
            'newVolunteer.phone' => 'required|string|regex:/^\+?\d{10,15}$/',
            'newVolunteer.vol_date' => 'required|date|before_or_equal:today',
            'newVolunteer.birth_date' => 'required|date|before:today',
            'newVolunteer.gender' => 'required|in:1,2',
        ], [
            'newVolunteer.name.required' => 'يرجى إدخال الاسم الثلاثي.',
            'newVolunteer.name.regex' => 'الاسم يجب أن يحتوي على أحرف ومسافات فقط.',
            'newVolunteer.name.max' => 'الاسم يجب ألا يزيد عن 255 حرفًا.',
            'newVolunteer.phone.required' => 'يرجى إدخال رقم الهاتف.',
            'newVolunteer.phone.regex' => 'رقم الهاتف يجب أن يكون بصيغة صحيحة ولا يقل عن 11 رقم.',
            'newVolunteer.vol_date.required' => 'يرجى إدخال تاريخ التطوع.',
            'newVolunteer.vol_date.date' => 'تاريخ التطوع غير صالح.',
            'newVolunteer.vol_date.before_or_equal' => 'تاريخ التطوع يجب أن يكون اليوم أو في الماضي.',
            'newVolunteer.birth_date.required' => 'يرجى إدخال تاريخ الميلاد.',
            'newVolunteer.birth_date.date' => 'تاريخ الميلاد غير صالح.',
            'newVolunteer.birth_date.before' => 'تاريخ الميلاد يجب أن يكون قبل اليوم.',
            'newVolunteer.gender.required' => 'يرجى تحديد الجنس.',
            'newVolunteer.gender.in' => 'القيمة المختارة للجنس غير صالحة.',
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

    public function updateEvent()
    {
        DB::beginTransaction();
        try {
            $this->event->event_date = $this->event_date;
            $this->event->contribution_id = $this->contribution_id;
            $this->event->section_id = $this->section_id;
            $this->event->notes = $this->notes;
            $this->event->save();

            $this->event->volunteers()->detach();
            foreach ($this->selectedVolunteers as $volunteerId => $volunteerData) {
                $this->event->volunteers()->attach($volunteerId, [
                    'event_date' => $this->event_date,
                    'tshirt' => $this->selectedVolunteersShirts[$volunteerId]['tshirt'] ?? 0,
                ]);
            }

            DB::commit();
            session()->flash('message', 'تم تحديث الحدث بنجاح.');
            return redirect()->route('volunteer.event.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'حدث خطأ أثناء تحديث الحدث. يرجى المحاولة مرة أخرى.');
        }
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
