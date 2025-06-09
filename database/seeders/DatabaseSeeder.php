<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Association;
use App\Models\MemoryCards\Organization;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Criação do usuário Rafael
        $rafael = User::create([
            'name' => 'Rafael Menezes',
            'email' => 'devmenezes@outlook.com',
            'password' => bcrypt('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Associação GLOBAL (Super Admin sem vínculo com organização)
        Association::create([
            'user_id' => $rafael->id,
            'role' => Role::SUPER_ADMIN,
            'associable_type' => null,
            'associable_id' => null,
        ]);

        // ORGANIZAÇÃO
        $org = Organization::create([
            'name' => 'Memory Cards',
            'slug' => 'memory-cards',
            'color' => 'blue',
            'active' => true,
        ]);

        $rafael->address()->create([
            'street' => 'Rua A',
            'city' => 'São Paulo',
            'state' => 'SP',
            'postal_code' => '01000-000',
        ]);

        $org->address()->create([
            'street' => 'Av Central',
            'city' => 'Brasília',
            'state' => 'DF',
            'postal_code' => '70000-000',
        ]);

        Association::create([
            'user_id' => $rafael->id,
            'role' => Role::ADMIN,
            'associable_type' => Organization::class,
            'associable_id' => $org->id,
        ]);

        // Outros seeders
        $this->call([
            SettingsSedder::class,
            MemoryCardsSeeder::class,
            CedSeeder::class,
        ]);
    }
}
