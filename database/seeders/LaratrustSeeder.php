<?php

namespace Database\Seeders;

use App\Models\User;
use Laratrust\Models\Role;
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
        // Step 0: Empty the existing users, roles, and permissions
        DB::table('role_user')->delete();
        DB::table('permission_user')->delete();
        DB::table('permission_role')->delete();
        DB::table('users')->delete();
        DB::table('permissions')->delete();
        DB::table('roles')->delete();

    
        // Step 1: Create the "owner" role if it doesn't exist
        $ownerRole = Role::create([
            'name' => 'owner',
            'display_name' => 'مدير',
            'description' => 'This role has full access to the system.',
            'guard_name' => 'super_admin',
        ]);
    
        $adminUser = User::create([
            'name' => 'Owner',
            'username' => 'owner_vms',
            'email' => 'owner@vms.com',
            'password' => bcrypt('owner_vms'),
        ]);
    
        $adminUser->roles()->sync([$ownerRole->id]);
    
        $allPermissions = Permission::pluck('id')->toArray();
        $ownerRole->permissions()->sync($allPermissions);
    
        foreach (config('roles.super_admin') as $roleName => $data) {
    
            foreach ($data['permissions'] as $permission => $translation) {
                $permissionInstance = Permission::firstOrCreate([
                    'name' => $permission . '-' . $roleName,
                ], [
                    'display_name' => $translation . ' ' . $data['title'],
                    'description' => 'هذا الإذن يسمح بـ ' . $translation . ' ' . $data['title'],
                    'guard_name' => 'super_admin',
                ]);
    
                $ownerRole->permissions()->syncWithoutDetaching([$permissionInstance->id]);
            }
        }
    
        $permissions = $ownerRole->permissions->pluck('name')->toArray();
        $adminUser->syncPermissions($permissions);
    }
    
    
    
}