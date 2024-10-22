<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employment extends Model
{
    use HasFactory;

    const STATUS = [
        'E' => ['有効','text-bg-success'],
        'D' => ['無効','text-bg-danger'],
    ];

    protected $guarded = [];

    public function employment(){
      return $this->hasOne(Employment::class);
    }
}
