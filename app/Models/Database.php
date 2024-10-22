<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Database extends Model
{
    use HasFactory;
    protected $table = 'site_dbs';
    // 更新不可は特になし
    protected $guarded = [];

    const RULES = [
        'server_id'    => ['required'],
        'host'         => ['required', 'string', 'max:255'],
        'phpmyadmin'   => ['required', 'string', 'max:255'],
        'login_id'     => ['nullable', 'string', 'max:255'],
        'login_pass'   => ['nullable', 'string', 'max:255'],
        'user'         => ['required', 'string', 'max:255'],
        'pass'         => ['required', 'string', 'max:255'],
        'note'         => ['nullable', 'string', 'max:5000'],
    ];
}
