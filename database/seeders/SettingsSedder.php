<?php

namespace Database\Seeders;

use App\Events\Auth\UserLoggedEvent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSedder extends Seeder
{
    public function run(): void
    {

        $defaults = [
            // ['group' => 'Cache', 'type' => 'integer', 'key' => 'cache_ttl_default', 'value' => '300', 'label' => 'Tempo de cache padrão (segundos)'],
            // ['group' => 'E-mail', 'type' => 'string', 'key' => 'support_email', 'value' => 'suporte@dominio.com', 'label' => 'E-mail de suporte'],
            // ['group' => 'Geral', 'type' => 'string', 'key' => 'timezone', 'value' => 'America/Sao_Paulo', 'label' => 'Fuso horário padrão'],
            // ['group' => 'Geral', 'type' => 'boolean', 'key' => 'maintenance_mode', 'value' => 'false', 'label' => 'Modo de manutenção'],
            // ['group' => 'Autenticação', 'type' => 'integer', 'key' => 'login_attempts_limit', 'value' => '5', 'label' => 'Limite de tentativas de login'],
            // ['group' => 'Autenticação', 'type' => 'integer', 'key' => 'login_block_minutes', 'value' => '15', 'label' => 'Tempo de bloqueio (minutos)'],
            // ['group' => 'Autenticação', 'type' => 'boolean', 'key' => 'register_enabled', 'value' => 'true', 'label' => 'Cadastro de usuários habilitado'],
            // ['group' => 'Geral', 'type' => 'string', 'key' => 'default_role', 'value' => 'viewer', 'label' => 'Perfil padrão'],
            // ['group' => 'Event Log', 'type' => 'boolean', 'key' => UserLoggedEvent::class, 'value' => 'true', 'label' => 'Login de usuário'],

            ['group' => 'Geral', 'type' => 'boolean', 'key' => 'REGISTER_ENABLED', 'value' => env('REGISTER_ENABLED'), 'label' => 'Usuários podem se Registrar?'],
            ['group' => 'Geral', 'type' => 'boolean', 'key' => 'LOG_DB_QUERIES', 'value' => true, 'label' => 'Queries do banco logadas'],

            ['group' => 'Event Log', 'type' => 'boolean', 'key' => 'UserLoggedEvent', 'value' => true, 'label' => 'User Login'],
            ['group' => 'Event Log', 'type' => 'boolean', 'key' => 'UserActivationEvent', 'value' => true, 'label' => 'User Activation'],
            ['group' => 'Event Log', 'type' => 'boolean', 'key' => 'UserDeactivationEvent', 'value' => true, 'label' => 'User Deactivation'],
            ['group' => 'Event Log', 'type' => 'boolean', 'key' => 'SettingsUpdatedEvent', 'value' => true, 'label' => 'Settings Updated'],

        ];

        foreach ($defaults as $setting) {
            DB::table('settings')->insert($setting);
        }

    }
}
