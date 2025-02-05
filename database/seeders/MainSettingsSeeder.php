<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MainSettings;

class MainSettingsSeeder extends Seeder
{
    public function run()
    {
        MainSettings::create([
            'accountId' => config('services.moysklad.accountId'),
            'ms_token' => config('services.moysklad.token'), // либо так -> env('MS_TOKEN')
            'UID_ms' => config('services.moysklad.UID_ms'), 
        ]);
        
        $this->command->info('MainSettings успешно обновлены.');
    }
}
