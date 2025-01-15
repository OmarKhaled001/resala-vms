<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $userId = $this->input('id'); // الحصول على الـ ID من الطلب

        $rules = [
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'role_id' => 'required',
        ];

        $rules['password'] =  !$userId ? 'required|string|min:8|confirmed' : 'nullable|string|min:8|confirmed';

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

            'role_id.required' => 'يجب اختيار دور',
        ];
    }
}
