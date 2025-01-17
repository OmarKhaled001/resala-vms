<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('branches')->delete();

        $branches = [
        [
            'name' => 'المعادي',
            'username' => 'vol_maadi',
            'phone' => '01068778340',
            'email' => 'volmaadi@vms.com',
            'password' => Hash::make('vol_maadi'),
        ],
        [
            'name' => 'المهنديسن',
            'phone' => '01074689752',
            'username' => 'vol_mohandseen',
            'email' => 'volmohandseen@vms.com',
            'password' => Hash::make('vol_mohandseen'),
        ],
        [
            'name' => 'فيصل',
            'phone' => '01044689752',
            'username' => 'vol_fasel',
            'email' => 'volfasel@vms.com',
            'password' => Hash::make('vol_fasel'),
        ],
        [
            'name' => 'حلوان',
            'phone' => '01133689752',
            'username' => 'vol_helwan',
            'email' => 'volhelwan@vms.com',
            'password' => Hash::make('vol_helwan'),
        ],
        [
            'name' => 'مصر الجديدة',
            'phone' => '01114622752',
            'username' => 'vol_mgedida',
            'email' => 'volmgedida@vms.com',
            'password' => Hash::make('vol_mgedida'),
        ],
        [
            'name' => 'أكتوبر',
            'phone' => '01119489752',
            'username' => 'vol_octobar',
            'email' => 'voloctobar@vms.com',
            'password' => Hash::make('vol_octobar'),
        ],
        [
            'name' => 'الاسكندرية',
            'phone' => '01224689752',
            'username' => 'vol_alexandria',
            'email' => 'volalexandria@vms.com',
            'password' => Hash::make('vol_alexandria'),
        ],
        [
            'name' => 'المقطم',
            'phone' => '01112189752',
            'username' => 'vol_moqatm',
            'email' => 'volmoqatm@vms.com',
            'password' => Hash::make('vol_moqatm'),
        ],
        [
            'name' => 'مدينة نصر',
            'phone' => '01114689972',
            'username' => 'vol_mnasr',
            'email' => 'volmnasr@vms.com',
            'password' => Hash::make('vol_mnasr'),
        ],
        
    ];

    Branch::insert($branches);

    }
}
