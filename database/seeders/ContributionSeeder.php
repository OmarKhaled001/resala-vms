<?php

namespace Database\Seeders;

use App\Models\Contribution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('contributions')->delete();

        $contributions = [
            [
                'name' => 'معرض رمزي',
                'value' => 1, 
                'is_active' => 1, 
            ],
            [
                'name' => 'معرض مجاني',
                'value' => 1, 
                'is_active' => 1, 
            ],
            [
                'name' => 'قافلة اطعام',
                'value' => 1, 
                'is_active' => 1, 
            ],
            [
                'name' => 'قافلة سوق خيري',
                'value' => 1, 
                'is_active' => 1, 
            ],
            [
                'name' => 'حفلة ابطال تحدي',
                'value' => 1, 
                'is_active' => 1, 
            ],
            [
                'name' => 'اورينتيشن',
                'value' => 1, 
                'is_active' => 1, 
            ],
            [
                'name' => 'يوم عائلي',
                'value' => 1, 
                'is_active' => 1, 
            ],
            [
                'name' => 'اجتماع ميداني',
                'value' => 1, 
                'is_active' => 1, 
            ],
            [
                'name' => 'كرنفال دعاية',
                'value' => 1, 
                'is_active' => 1, 
            ],
            [
                'name' => 'ميديا',
                'value' => 2, 
                'is_active' => 1, 
            ],
            [
                'name' => 'اتصالات',
                'value' => 2, 
                'is_active' => 1, 
            ],
            [
                'name' => 'ادارايات ميدانية',
                'value' => 1, 
                'is_active' => 1, 
            ],
            [
                'name' => 'اداريات من المنزل',
                'value' => 2, 
                'is_active' => 1, 
            ],
            [
                'name' => 'اجتماع من المنزل',
                'value' => 2, 
                'is_active' => 1, 
            ],
            [
                'name' => 'كامب مبيت',
                'value' => 1, 
                'is_active' => 1, 
            ],
            [
                'name' => 'حفلة فرع',
                'value' => 1, 
                'is_active' => 1, 
            ],
            [
                'name' => 'ورشة استقبال',
                'value' => 1, 
                'is_active' => 1, 
            ],
        ];

        Contribution::insert($contributions);
    }
}
