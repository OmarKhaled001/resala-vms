<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laratrust\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
 
    public function run()
    {
        foreach(config('roles.super_admin') as $role => $data) {
            foreach($data['permissions'] as $permission => $translation) {
                $sub_role = Permission::firstOrCreate([
                    'name'          => $permission . '-' . $role,
                    'display_name'  => $translation . ' ' . $data['title'],
                    'description'   => 'هذا الإذن يسمح بـ ' . $translation . ' ' . $data['title'],
                    'guard_name'    => 'super_admin',
                ]);
            }
        }
    }


}
