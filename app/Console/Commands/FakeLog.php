<?php

namespace App\Console\Commands;

use App\Models\LogEntry;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FakeLog extends Command
{
    protected $signature = 'fake-log {qtd=2}';

    protected $description = 'Generate fake logs directly using LogEntry model';

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

            $log = LogEntry::make()
                ->system($system)
                ->user($user['id'])
                ->description(Str::ucfirst(fake()->sentence()))
                ->level(fake()->randomElement($this->levels))
                ->ip(fake()->ipv4())
                ->resources(
                    collect(range(1, rand(1, 3)))
                        ->map(fn () => [
                            'table' => $system . '_table',
                            'id' => (string) fake()->randomNumber(3),
                        ])
                        ->toArray()
                );

            match ($type) {
                'raw' => $log->raw(fake()->sentence()),
                'insert' => $log->insert(['field' => fake()->word(), 'value' => fake()->word()]),
                'beforeAfter' => $log->beforeAfter(
                    ['status' => 'old', 'value' => fake()->word()],
                    ['status' => 'new', 'value' => fake()->word()]
                ),
                'remove' => $log->remove(['id' => rand(1, 1000), 'name' => fake()->name()]),
                'read' => $log->read(['admin', 'editor'], 'random test'),
            };

            $log->saveLog();
        }

        $this->info("✅ {$quantity} logs saved directly via builder.");
    }
}
