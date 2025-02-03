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
            'accountId' => '1dd5bd55-d141-11ec-0a80-055600047495',
            'ms_token' => config('services.moysklad.token'), // либо так -> env('MS_TOKEN')
            'UID_ms' => 'admin@smart_demo',
        ]);
    }
}
