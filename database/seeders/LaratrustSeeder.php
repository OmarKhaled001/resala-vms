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
        // Step 1: Create the "owner" role if it doesn't exist
        $ownerRole = Role::where('name', 'owner')->first();

        if (!$ownerRole) {
            $ownerRole = Role::create([
                'name' => 'owner',
                'display_name' => 'Owner',
                'description' => 'This role has full access to the system.',
                'guard_name' => 'super_admin',
            ]);
        }

        // Step 2: Create the "admin" user if it doesn't exist
        $adminUser = User::firstOrCreate([
            'email' => 'admin@vms.com',
        ], [
            'name' => 'Admin User',
            'username' => 'admin@vms',
            'email' => 'admin@vms.com',
            'password' => bcrypt('admin@vms'), // Set a secure password
        ]);

        // Step 3: Assign the "owner" role to the "admin" user
        $adminUser->roles()->sync([$ownerRole->id]);

        // Step 4: Create additional roles and permissions (if needed)
        foreach (config('roles.super_admin') as $role => $data) {
            // Create or retrieve the role
            $role = Role::firstOrCreate([
                'name' => $role,
                'display_name' => $data['title'],
                'description' => 'This role has specific permissions.',
                'guard_name' => 'super_admin',
            ]);

            // Create permissions for the role
            foreach ($data['permissions'] as $permission => $translation) {
                $permission = Permission::firstOrCreate([
                    'name' => $permission . '-' . $role->name,
                    'display_name' => $translation . ' ' . $data['title'],
                    'description' => 'هذا الإذن يسمح بـ ' . $translation . ' ' . $data['title'],
                    'guard_name' => 'super_admin',
                ]);

                // Assign the permission to the role
                $role->permissions()->syncWithoutDetaching([$permission->id]);
            }
        }

        $allPermissions = Permission::pluck('name')->toArray(); // Fetch all permissions
        $adminUser->syncPermissions($allPermissions);
    }
}