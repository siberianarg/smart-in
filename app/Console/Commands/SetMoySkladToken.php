<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MainSettings;

class SetMoySkladToken extends Command
{
    protected $signature = 'moysklad:set-token {token}';
    protected $description = 'Сохранить токен МойСклад в базу данных';

    public function handle()
    {
        $token = $this->argument('token');

        // Обновляем или создаём запись в main_settings
        $settings = MainSettings::updateOrCreate(
            ['accountId' => config('services.moysklad.accountId')],
            [
                'ms_token' => $token,
                'UID_ms' => config('services.moysklad.UID_ms'),
            ]
        );

        $this->info('Токен МойСклад успешно сохранён.');


        $this->info("Текущие настройки:");
        $this->line("Account ID: " . $settings->accountId);
        $this->line("UID MS: " . $settings->UID_ms);
        $this->line("Токен: " . $settings->ms_token);
    }
}
