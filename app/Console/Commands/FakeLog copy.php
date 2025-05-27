<?php

namespace App\Console\Commands;

use App\Models\LogEntry;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FakeLog extends Command
{
    protected $signature = 'fake-log {qtd=2}';

    protected $description = 'Gera logs falsos aleatórios para MongoDB';

    protected array $sistemas = ['Festas', 'Escola', 'Clínica', 'Farmácia'];

    protected array $tipos = ['raw', 'update', 'delete', 'insert', 'read'];

    protected array $niveis = ['info', 'debug', 'error', 'audit', 'warning'];

    public function handle(): void
    {

        $usuarios = [
            ['id' => fake()->randomNumber(), 'nome' => fake()->name()],
            ['id' => fake()->randomNumber(), 'nome' => fake()->name()],
            ['id' => fake()->randomNumber(), 'nome' => fake()->name()],
        ];
        $qtd = (int) $this->argument('qtd');

        for ($i = 0; $i < $qtd; $i++) {
            $usuario = fake()->randomElement($usuarios);
            $tipo = fake()->randomElement($this->tipos);
            $log = LogEntry::make()
                ->sistema(fake()->randomElement($this->sistemas))
                ->usuario($usuario['id'])
                ->descricao(Str::ucfirst(fake()->sentence()))
                ->nivel(fake()->randomElement($this->niveis))
                ->ip(fake()->ipv4())
                ->referencias([
                    fake()->randomElement($this->sistemas) . '.tabela_' . fake()->word() . '#' . rand(100, 999),
                ]);

            match ($tipo) {
                'raw' => $log->raw(fake()->sentence()),
                'insert' => $log->insert(['campo' => fake()->word(), 'valor' => fake()->word()]),
                'update' => $log->beforeAfter(
                    ['status' => 'antigo', 'valor' => fake()->word()],
                    ['status' => 'novo', 'valor' => fake()->word()]
                ),
                'delete' => $log->remove(['id' => rand(1, 1000), 'nome' => fake()->name()]),
                'read' => $log->read(['admin', 'editor'], 'teste aleatório'),
            };

            $log->saveLog();
        }

        $this->info("✅ {$qtd} logs gerados com sucesso.");
    }
}
