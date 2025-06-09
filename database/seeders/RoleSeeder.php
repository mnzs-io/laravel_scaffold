<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Role::all() as $roleName) {
            Role::firstOrCreate(
                ['name' => $roleName],
                // Removido guard_name, pois sua tabela de roles agora não tem mais essa coluna
                ['label' => ucfirst(strtolower(str_replace('_', ' ', $roleName)))]
            );
        }
    }
}
