<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Branch;
use App\Models\Activity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LaratrustSeeder::class);

        // DB::table('users')->insert([
        //     'name' => 'Omar Khaled',
        //     'username' => 'omar_khaled',
        //     'email' => 'omar@vms.app',
        //     'password' => Hash::make('omar@vms.app'),
        // ]);

        // $branches = [
        //     [
        //         'name' => 'المعادي',
        //         'username' => 'vol_maadi',
        //         'phone' => '01068778340',
        //         'email' => 'volmaadi@vms.app',
        //         'password' => Hash::make('volmaadi@vms.app'),
        //     ],
        //     [
        //         'name' => 'المهنديسن',
        //         'phone' => '01074689752',
        //         'username' => 'vol_mohandseen',
        //         'email' => 'volmohandseen@vms.app',
        //         'password' => Hash::make('volmohandseen@vms.app'),
        //     ],
        //     [
        //         'name' => 'فيصل',
        //         'phone' => '01044689752',
        //         'username' => 'vol_fasel',
        //         'email' => 'volfasel@vms.app',
        //         'password' => Hash::make('volfasel@vms.app'),
        //     ],
        //     [
        //         'name' => 'حلوان',
        //         'phone' => '01133689752',
        //         'username' => 'vol_helwan',
        //         'email' => 'volhelwan@vms.app',
        //         'password' => Hash::make('volhelwan@vms.app'),
        //     ],
        //     [
        //         'name' => 'مصر الجديدة',
        //         'phone' => '01114622752',
        //         'username' => 'vol_mgedida',
        //         'email' => 'volmgedida@vms.app',
        //         'password' => Hash::make('volmgedida@vms.app'),
        //     ],
        //     [
        //         'name' => 'أكتوبر',
        //         'phone' => '01119489752',
        //         'username' => 'vol_octobar',
        //         'email' => 'voloctobar@vms.app',
        //         'password' => Hash::make('voloctobar@vms.app'),
        //     ],
        //     [
        //         'name' => 'الاسكندرية',
        //         'phone' => '01224689752',
        //         'username' => 'vol_alexandria',
        //         'email' => 'volalexandria@vms.app',
        //         'password' => Hash::make('volalexandria@vms.app'),
        //     ],
        //     [
        //         'name' => 'المقطم',
        //         'phone' => '01112189752',
        //         'username' => 'vol_moqatm',
        //         'email' => 'volmoqatm@vms.app',
        //         'password' => Hash::make('volmaadi@vms.app'),
        //     ],
        //     [
        //         'name' => 'مدينة نصر',
        //         'phone' => '01114689972',
        //         'username' => 'vol_mnasr',
        //         'email' => 'volmnasr@vms.app',
        //         'password' => Hash::make('volmnasr@vms.app'),
        //     ],
            
        // ];

        // foreach ($branches as $branch) {
        //     Branch::create($branch);
        // };

        // $activities = [
        //     [
        //         'name' => 'معارض داخلي',
        //         'username' => 'maared',
        //         'phone' => '01112526437',
        //         'email' => 'maared@vms.app',
        //         'password' => Hash::make('maared@vms.app'),
        //     ],
        //     [
        //         'name' => 'الفرز',
        //         'phone' => '01114689752',
        //         'username' => 'farz',
        //         'email' => 'farz@vms.app',
        //         'password' => Hash::make('farz@vms.app'),
        //     ],
        //     [
        //         'name' => 'RTC',
        //         'phone' => '01026483721',
        //         'username' => 'rtc',
        //         'email' => 'rtc@vms.app',
        //         'password' => Hash::make('rtc@vms.app'),
        //     ],
         
            
        // ];
        // foreach ($activities as $activity) {
        //     Activity::create($activity);
        // };
    }
}
