<?php

return [
    'super_admin' => [
        'branch' => [
            'title' => 'الفروع',
            'permissions' => [
                'read' => 'قراءة',
                'create' => 'إنشاء',
                'update' => 'تعديل',
                'delete' => 'حذف',
            ],
        ],
        'activity' => [
            'title' => 'الأنشطة',
            'permissions' => [
                'read' => 'قراءة',
                'create' => 'إنشاء',
                'update' => 'تعديل',
                'delete' => 'حذف',
                'import' => 'إستيراد',
                'export' => 'تصدير',
            ],
        ],
        'group' => [
            'title' => 'الفرق',
            'permissions' => [
                'read' => 'قراءة',
                'export' => 'إستيراد',
            ],
        ],
        'section' => [
            'title' => 'اللجان',
            'permissions' => [
                'read' => 'قراءة',
                'create' => 'إنشاء',
                'update' => 'تعديل',
                'delete' => 'حذف',
            ],
        ],
        'contribution' => [
            'title' => 'المشاركات',
            'permissions' => [
                'read' => 'قراءة',
                'create' => 'إنشاء',
                'update' => 'تعديل',
                'delete' => 'حذف',
            ],
        ],
        'user' => [
            'title' => 'المستخدمون',
            'permissions' => [
                'read' => 'قراءة',
                'create' => 'إنشاء',
                'update' => 'تعديل',
                'delete' => 'حذف',
            ],
        ],
        'role' => [
            'title' => 'الأدوار',
            'permissions' => [
                'read' => 'قراءة',
                'create' => 'إنشاء',
                'update' => 'تعديل',
                'delete' => 'حذف',
            ],
        ],
        'activity_log' => [
            'title' => 'سجل العمليات',
            'permissions' => [
                'read' => 'قراءة',
            ],
        ],

    ],
    'volunteer' => [
        'volunteers' => [
            'title' => 'المتطوعين',
            'permissions' => [
                'read' => 'قراءة',
                'create' => 'إنشاء',
                'update' => 'تعديل',
                'delete' => 'حذف',
            ],
        ],
    ],
];
