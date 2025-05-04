<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $rafael = User::create([
            'name' => 'Rafael Menezes',
            'email' => 'devmenezes@outlook.com',
            'password' => bcrypt('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $adminRole = Role::create([
            'name' => Roles::ADMIN,
        ]);

        Role::create([
            'name' => Roles::CLIENT,
        ]);

        $permissionAdminUser = Permission::create([
            'name' => 'user.admin',
        ]);

        $adminRole->givePermissionTo($permissionAdminUser);

        $rafael->assignRole($adminRole);
    }
}
