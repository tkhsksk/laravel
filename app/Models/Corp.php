<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
use App\Models\Department;
use App\Models\Location;
use App\Rules\RuleKana;

class Corp extends Model
{
    use HasFactory;

    protected $table = 'corps';

    protected $guarded = [];

    public static function rules()
    {
        return [
            'name'               => ['required', 'max:50'],
            'note'               => ['nullable', 'max:5000'],
            'establishmented_at' => ['required'],
            'kana'               => ['required', 'max:50', new RuleKana],
            'cto'                => ['required', 'max:50'],
            'corp_mynumber'      => ['required', 'min:13', 'max:13'],
            'capital_stock'      => ['required', 'max:50'],
        ];
    }

    /**
     * adminとのリレーション
     */
    public function admin()
    {
        return $this->hasManyThrough(
            Admin::class, 
            Department::class, 
            Location::class
        );
    }

    /**
     * departmentとのリレーション
     */
    public function department()
    {
        return $this->hasManyThrough( 
            Department::class, 
            Location::class
        );
    }

    /**
     * locationとのリレーション
     */
    public function location()
    {
        return $this->hasMany(Location::class);
    }
}
