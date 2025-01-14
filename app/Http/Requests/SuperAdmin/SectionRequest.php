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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $sectionId = $this->input('id');

        $rules = [
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sections', 'username')->ignore($sectionId),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('sections', 'email')->ignore($sectionId),
            ],
            'contribution_id' => 'required|array',
            'contribution_id.*' => 'exists:contributions,id', // التأكد من أن المساهمات موجودة
        ];

        // تأكيد كلمة المرور عند الإنشاء فقط، وجعلها اختيارية عند التحديث
        $rules['password'] = !$sectionId ? 'required|string|min:8|confirmed' : 'nullable|string|min:8|confirmed';

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'الاسم يجب أن يكون نصًا.',
            'name.max' => 'الاسم يجب ألا يزيد عن 255 حرفًا.',

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

            'contribution_id.required' => 'يجب اختيار مشاركة على الأقل.',
            'contribution_id.exists' => 'القيمة المحددة للمشاركة غير صالحة.',
        ];
    }
}
