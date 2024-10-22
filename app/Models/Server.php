<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;
    protected $table = 'site_servers';
    // 更新不可は特になし
    protected $guarded = [];

    const RULES = [
        'name'       => ['nullable', 'string', 'max:255'],
        'url'        => ['required', 'string', 'max:255'],
        'plan'       => ['nullable', 'string', 'max:255'],
        'login_id'   => ['nullable', 'string', 'max:255'],
        'login_pass' => ['nullable', 'string', 'max:255'],
        'mail_receive' => ['nullable', 'string', 'max:255'],
        'mail_send'    => ['nullable', 'string', 'max:255'],
        'note'         => ['nullable', 'string', 'max:5000'],
    ];
}
