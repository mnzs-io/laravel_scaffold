<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class LocalSeeder extends Seeder
{
    public function run(): void
    {

        User::factory(30)->state(new Sequence(
            fn (Sequence $sequence) => [
                'active' => collect([true, false])->random(),
            ],
        ))->create()
            ->each(function ($user) use ($clientRole) {
                $user->assignRole($clientRole);
            });
    }
}
