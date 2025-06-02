<?php

namespace App\Console\Commands;

use App\Enums\AuditLogLevel;
use App\Enums\AuditLogType;
use App\Models\LogEntry;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FakeLog extends Command
{
    protected $signature = 'fake-log {qtd=2}';

    protected $description = 'Generate fake logs directly using LogEntry model';

    protected array $systems = ['Parties', 'School', 'Clinic', 'Pharmacy'];

    public function handle(): void
    {
        $users = User::factory()->count(3)->make();

        $quantity = (int) $this->argument('qtd');

        for ($i = 0; $i < $quantity; $i++) {
            $user = fake()->randomElement($users);
            $type = fake()->randomElement(AuditLogType::cases());
            $level = fake()->randomElement(AuditLogLevel::cases());
            $system = config('app.log.key') ?? fake()->randomElement($this->systems);
            $table = config('app.log.collection') . '_fake_log_collection';

            $log = (new LogEntry)->setTable($table)
                ->system($system)
                ->user($user)
                ->description(Str::ucfirst(fake()->sentence()))
                ->level($level)
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
                AuditLogType::RAW => $log->raw(fake()->sentence()),
                AuditLogType::INSERT => $log->insert(['field' => fake()->word(), 'value' => fake()->word()]),
                AuditLogType::BEFORE_AFTER => $log->beforeAfter(
                    ['status' => 'old', 'value' => fake()->word()],
                    ['status' => 'new', 'value' => fake()->word()]
                ),
                AuditLogType::REMOVE => $log->remove(['id' => rand(1, 1000), 'name' => fake()->name()]),
                AuditLogType::READ => $log->read(['admin', 'editor'], 'random test'),
                AuditLogType::EVENT => $log->event('FakeEvent', [
                    'message' => 'teste',
                ]),
            };

            $log->commit();
        }

        $this->info("✅ {$quantity} logs saved directly via builder.");
    }
}
