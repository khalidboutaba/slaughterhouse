<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'controller',
        'action',
        'url',
        'method',
        'ip',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
