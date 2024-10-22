<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $table = 'notes';
    protected $guarded = [];

    const RULES = [
        'register_id' => ['required'],
        'title'       => ['nullable', 'string', 'max:255'],
        'note'        => ['required', 'string', 'max:5000'],
    ];
}
