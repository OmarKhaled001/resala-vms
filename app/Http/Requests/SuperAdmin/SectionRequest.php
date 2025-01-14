<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $sectionId = $this->input('id'); // الحصول على الـ ID من الطلب

        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'string',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('activities', 'username')->ignore($sectionId),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('activities', 'email')->ignore($sectionId),
            ],
            'section_id' => 'required|array',
            'section_id.*' => 'exists:sections,id',
        ];

        $rules['password'] =  !$sectionId ? 'required|string|min:8|confirmed' : 'nullable|string|min:8|confirmed';

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'الاسم يجب أن يكون نصًا.',
            'name.max' => 'الاسم يجب ألا يزيد عن 255 حرفًا.',
            
            'description.string' => 'الاسم يجب أن يكون نصًا.',

            'username.required' => 'حقل اسم المستخدم مطلوب.',
            'username.string' => 'اسم المستخدم يجب أن يكون نصًا.',
            'username.max' => 'اسم المستخدم يجب ألا يزيد عن 255 حرفًا.',
            'username.unique' => 'اسم المستخدم مُستخدم بالفعل.',
    
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.email' => 'البريد الإلكتروني يجب أن يكون بصيغة صحيحة.',
            'email.unique' => 'البريد الإلكتروني مُستخدم بالفعل.',
            
            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.string' => 'كلمة المرور يجب أن تكون نصًا.',
            'password.min' => 'كلمة المرور يجب ألا تقل عن 8 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',

            'contribution_id.required' => 'يجب اختيار مشاركة علي الاقل',
            'contribution_id.exists' => 'القيمة المحددة للمشاركة غير صالحة.',
        ];
    }
}
