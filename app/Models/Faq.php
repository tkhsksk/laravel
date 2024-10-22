<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table   = 'faqs';
    protected $guarded = [];

    const RULES = [
        'question'      => ['required', 'string', 'max:255'],
        'browsable_ids' => ['nullable'],
        'register_id'   => ['required'],
        'updater_id'    => ['nullable'],
        'department_id' => ['nullable'],
        'answer'        => ['required', 'string', 'max:65535'],
        'role'          => ['required'],
    ];
}
