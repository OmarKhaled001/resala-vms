<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('activities')->delete();

            $activities = [
            [
                'name' => 'معارض داخلي',
                'username' => 'maared_khariji',
                'email' => 'maared_khariji@vms.app',
                'password' => Hash::make('maared'),
            ],
            [
                'name' => 'معارض داخلي',
                'username' => 'maared_dakhli',
                'email' => 'maared_dakhli@vms.app',
                'password' => Hash::make('maared'),
            ],
            [
                'name' => 'الفرز',
                'username' => 'farz',
                'email' => 'farz@vms.app',
                'password' => Hash::make('farz'),
            ],
            [
                'name' => 'RTC',
                'username' => 'rtc',
                'email' => 'rtc@vms.app',
                'password' => Hash::make('rtc'),
            ],
            [
                'name' => 'قوافل طبية',
                'username' => 'qwafel_tebia', 
                'email' => 'qwafel_tebia@vms.app',
                'password' => Hash::make('qwafel_tebia'),
            ],
            [
                'name' => 'محو الأمية',
                'username' => 'mahw_al_omya',
                'email' => 'mahw_al_omya@vms.app',
                'password' => Hash::make('mahw_al_omya'),
            ],
            [
                'name' => 'مساعدات',
                'username' => 'musaadat', 
                'email' => 'musaadat@vms.app',
                'password' => Hash::make('musaadat'),
            ],
            [
                'name' => 'قوافل خارجي',
                'username' => 'qwafel_khariji', 
                'email' => 'qwafel_khariji@vms.app',
                'password' => Hash::make('qwafel_khariji'),
            ],
            [
                'name' => 'قوافل داخلي',
                'username' => 'qwafel_dakhli', 
                'email' => 'qwafel_dakhli@vms.app',
                'password' => Hash::make('qwafel_dakhli'),
            ],
        ];

        Activity::insert($activities);
    }
}
