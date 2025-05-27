<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FakeLogViaChannel extends Command
{
    protected $signature = 'fake-log:channel {qtd=2}';

    protected $description = 'Generate fake logs via passive log channel';

    protected array $systems = ['Parties', 'School', 'Clinic', 'Pharmacy'];

    protected array $types = ['raw', 'beforeAfter', 'remove', 'insert', 'read'];

    protected array $levels = ['info', 'debug', 'error', 'notice', 'warning'];

    public function handle(): void
    {
        $users = [
            ['id' => fake()->randomNumber(), 'name' => fake()->name()],
            ['id' => fake()->randomNumber(), 'name' => fake()->name()],
            ['id' => fake()->randomNumber(), 'name' => fake()->name()],
        ];

        $quantity = (int) $this->argument('qtd');

        for ($i = 0; $i < $quantity; $i++) {
            $user = fake()->randomElement($users);
            $type = fake()->randomElement($this->types);
            $system = fake()->randomElement($this->systems);
            $level = fake()->randomElement($this->levels);

            $context = [
                'origin' => $system,
                'user' => $user['id'],
                'type' => $type,
                'resources' => collect(range(1, rand(1, 3)))
                    ->map(fn () => [
                        'table' => $system . '_table',
                        'id' => (string) rand(100, 999),
                    ])
                    ->toArray(),
                'data' => match ($type) {
                    'raw' => ['message' => fake()->sentence()],
                    'insert' => ['after' => ['field' => fake()->word(), 'value' => fake()->word()]],
                    'beforeAfter' => [
                        'before' => ['status' => 'old', 'value' => fake()->word()],
                        'after' => ['status' => 'new', 'value' => fake()->word()],
                    ],
                    'remove' => ['before' => ['id' => rand(1, 1000), 'name' => fake()->name()]],
                    'read' => ['profiles' => ['admin', 'editor'], 'reason' => 'random test'],
                    default => [],
                },
            ];

            Log::channel('auditoria')->{$level}(Str::ucfirst(fake()->sentence()), $context);
        }

        $this->info("✅ {$quantity} logs sent via 'auditoria' channel.");
    }
}
