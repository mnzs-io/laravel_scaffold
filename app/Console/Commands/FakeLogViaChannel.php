<?php

namespace App\Console\Commands;

use App\Enums\AuditLogLevel;
use App\Enums\AuditLogType;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FakeLogViaChannel extends Command
{
    protected $signature = 'fake-log:channel {qtd=2}';

    protected $description = 'Generate fake logs via passive log channel';

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

            $context = [
                'origin' => $system,
                'user' => $user,
                'type' => $type,
                'resources' => collect(range(1, rand(1, 3)))
                    ->map(fn () => [
                        'table' => $system . '_table',
                        'id' => (string) rand(100, 999),
                    ])
                    ->toArray(),
                'data' => match ($type) {
                    AuditLogType::RAW => ['message' => fake()->sentence()],
                    AuditLogType::INSERT => ['after' => ['field' => fake()->word(), 'value' => fake()->word()]],
                    AuditLogType::BEFORE_AFTER => [
                        'before' => ['status' => 'old', 'value' => fake()->word()],
                        'after' => ['status' => 'new', 'value' => fake()->word()],
                    ],
                    AuditLogType::REMOVE => ['before' => ['id' => rand(1, 1000), 'name' => fake()->name()]],
                    AuditLogType::READ => ['profiles' => ['admin', 'editor'], 'reason' => 'random test'],
                    AuditLogType::EVENT => ['event' => 'FakeEvent', 'message' => 'teste'],
                },
                'fake_collection' => true,
            ];

            Log::channel('auditoria')->{$level->value}(Str::ucfirst(fake()->sentence()), $context);
        }

        $this->info("✅ {$quantity} logs sent via 'auditoria' channel.");
    }
}
