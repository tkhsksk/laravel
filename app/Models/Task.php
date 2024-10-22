<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    protected $guarded = [];

    const STATUS = [
        'N' => ['新規','secondary'],
        'P' => ['進行中','warning'],
        'E' => ['完了済','success'],
    ];

    public function taskCategory()
    {
        return $this->belongsTo(TaskCategory::class, 'category_id');
    }
}
