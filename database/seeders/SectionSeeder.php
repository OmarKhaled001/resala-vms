<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('sections')->delete();

        $sections = [
            [
                'name' => 'المعارض',
                'username' => 'almaared',
                'email' => 'almaared@vms.app',
                'is_active' => 1,
                'password' => Hash::make('almaared'),
            ],
            [
                'name' => 'المتابعة',
                'username' => 'almotaba',
                'email' => 'almotaba@vms.app',
                'is_active' => 1,
                'password' => Hash::make('almotaba'),
            ],
            [
                'name' => 'الاتصالات',
                'username' => 'alettisalat',
                'email' => 'alettisalat@vms.app',
                'is_active' => 1,
                'password' => Hash::make('alettisalat'),
            ],
            [
                'name' => 'الاشبال',
                'username' => 'aleshbal',
                'email' => 'aleshbal@vms.app',
                'is_active' => 1,
                'password' => Hash::make('aleshbal'),
            ],
            [
                'name' => 'الاطعام',
                'username' => 'aletam', //
                'email' => 'aletam@vms.app',
                'is_active' => 1,
                'password' => Hash::make('aletam'),
            ],
            [
                'name' => 'السوق الخيري',
                'username' => 'souk_khairi',
                'email' => 'souk_khairi@vms.app',
                'is_active' => 1,
                'password' => Hash::make('souk_khairi'),
            ],
            [
                'name' => 'ابطال التحدي',
                'username' => 'abtal_tahadi',
                'email' => 'abtal_tahadi@vms.app',
                'is_active' => 1,
                'password' => Hash::make('abtal_tahadi'),
            ],
            [
                'name' => 'الدعاية',
                'username' => 'aldaea',
                'email' => 'aldaea@vms.app',
                'is_active' => 1,
                'password' => Hash::make('aldaea'),
            ],
            [
                'name' => 'الموارد البشرية',
                'username' => 'hr',
                'email' => 'hr@vms.app',
                'is_active' => 1,
                'password' => Hash::make('hr'),
            ],
            [
                'name' => 'الفرع',
                'username' => 'alfar',
                'email' => 'alfar@vms.app',
                'is_active' => 1,
                'password' => Hash::make('alfar'),
            ],
        ];

        Section::insert($sections);
    }
}
