<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = false;
    protected $fillable = [
        'ms_uuid',
        'description',
        'is_completed',
        'moysklad_task_id',
        'due_date',
    ];
}
