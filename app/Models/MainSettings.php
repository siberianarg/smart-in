<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainSettings extends Model
{
    use HasFactory;

    protected $table = 'main_settings';

    protected $fillable = [
        'accountId',
        'ms_token',
        'UID_ms',
    ];

    public $timestamps = false; 
}
