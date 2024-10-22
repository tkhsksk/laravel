<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Location;
use App\Models\Admin;

class Department extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Locationとのリレーション
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Adminとのリレーション
     */
    public function admin()
    {
       return $this->hasMany(Admin::class);
    }
}
