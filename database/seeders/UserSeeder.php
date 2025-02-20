<?php

namespace Database\Seeders;

use AmdadulHaq\Guard\Models\Permission;
use AmdadulHaq\Guard\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('users')->exists() || DB::table('roles')->exists()) {
            return;
        }

        $items = [
            'user' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'role' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'blog' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'language' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'setting' => ['view', 'update'],
            'currency' => ['viewAny', 'view', 'create', 'update', 'delete'],
        ];

        $role = Role::create([
            'name' => 'administrator',
            'label' => 'Administrator',
        ]);

        $permissions = [];

        foreach ($items as $group => $permissionNames) {
            foreach ($permissionNames as $name) {
                $permissions[] = [
                    'name' => $group.'.'.$name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        Permission::insert($permissions);

        foreach ($permissions as $permissionData) {
            $permission = Permission::where('name', $permissionData['name'])->first();
            $role->givePermissionTo($permission);
        }

        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'email_verified_at' => now(),
        ]);

        $user->assignRole($role);
    }
}
