<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{
    use HasFactory;

    protected $table = "manuals";
    protected $guarded = [];

    const STATUS = [
        'E' => ['有効','text-bg-success'],
        'D' => ['無効','text-bg-danger'],
    ];

    const RULES = [
        'title'         => ['required', 'string', 'max:255'],
        'updatable_ids' => ['nullable'],
        'register_id'   => ['required'],
        'updater_id'    => ['nullable'],
        'department_id' => ['nullable'],
        'note'          => ['required', 'string', 'max:50000'],
    ];
}
