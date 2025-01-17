<?php

return [
    'super_admin' => [
        'branches' => [
            'title' => 'الفروع',
            'permissions' => [
                'read' => 'قراءة',
                'create' => 'إنشاء',
                'update' => 'تعديل',
                'delete' => 'حذف',
            ],
        ],
        'activities' => [
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
        'groups' => [
            'title' => 'الفرق',
            'permissions' => [
                'read' => 'قراءة',
                'export' => 'إستيراد',
            ],
        ],
        'sections' => [
            'title' => 'اللجان',
            'permissions' => [
                'read' => 'قراءة',
                'create' => 'إنشاء',
                'update' => 'تعديل',
                'delete' => 'حذف',
            ],
        ],
        'contributions' => [
            'title' => 'المشاركات',
            'permissions' => [
                'read' => 'قراءة',
                'create' => 'إنشاء',
                'update' => 'تعديل',
                'delete' => 'حذف',
            ],
        ],
        'users' => [
            'title' => 'المستخدمون',
            'permissions' => [
                'read' => 'قراءة',
                'create' => 'إنشاء',
                'update' => 'تعديل',
                'delete' => 'حذف',
            ],
        ],
        'roles' => [
            'title' => 'الأدوار',
            'permissions' => [
                'read' => 'قراءة',
                'create' => 'إنشاء',
                'update' => 'تعديل',
                'delete' => 'حذف',
            ],
        ],
        'activity_logs' => [
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
