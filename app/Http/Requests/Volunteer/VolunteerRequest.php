<?php

namespace App\Http\Requests\Volunteer;

use Illuminate\Foundation\Http\FormRequest;

class VolunteerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Allow all users to make this request.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'newVolunteer.name' => 'required|string|max:255|regex:/^[\pL\s]+$/u',
            'newVolunteer.phone' => 'required|string|regex:/^\+?\d{10,15}$/',
            'newVolunteer.vol_date' => 'required|date|before_or_equal:today',
            'newVolunteer.birth_date' => 'required|date|before:today',
            'newVolunteer.gender' => 'required|in:1,2',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
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
        ];
    }
}