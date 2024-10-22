<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites';
    protected $guarded = [];

    const RULES = [
        'register_id' => ['required'],
        'contents_id' => ['required'],
        'type'        => ['required'],
    ];
}
