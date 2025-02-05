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
        MainSettings::updateOrCreate(
            ['accountId' => config('services.moysklad.accountId')],
            [
                'ms_token' => $token,
                'UID_ms' => config('services.moysklad.UID_ms'),
            ]
        );

        $this->info('Токен МойСклад успешно сохранён.');
    }
}
