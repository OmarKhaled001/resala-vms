<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BranchRequest extends FormRequest
{
    /**
     * تحديد ما إذا كان المستخدم مخولًا بعمل هذا الطلب.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * الحصول على قواعد التحقق التي تنطبق على الطلب.
     *
     * @return array
     */
    public function rules()
    {
        $branchId = $this->input('id'); // الحصول على الـ ID من الطلب

        $rules = [
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('branches', 'username')->ignore($branchId),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('branches', 'email')->ignore($branchId),
            ],
            'activity_id' => 'required|array',
            'activity_id.*' => 'exists:activities,id',
        ];

        $rules['password'] =  !$branchId ? 'required|string|min:8|confirmed' : 'nullable|string|min:8|confirmed';

        return $rules;
    }

    /**
     * الحصول على رسائل الخطأ المخصصة للتحقق من الطلب.
     *
     * @return array
     */
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

            'activity_id.required' => 'يجب اختيار نشاط',
            'activity_id.exists' => 'القيمة المحددة لنشاط غير صالحة.',
        ];
    }
}
