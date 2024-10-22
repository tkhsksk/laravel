<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
use App\Models\Department;
use App\Models\Location;
use App\Models\Corp;

class Location extends Model
{
    use HasFactory;

    const LOCATION_STATUS = [
        'U' => ['入居中','text-bg-success'],
        'N' => ['未入居','text-bg-danger'],
        'D' => ['退去済','text-bg-dark'],
    ];

    const RULES = [
        'corp_id'         => ['required'],
        'name'            => ['required', 'string', 'max:255'],
        'post'            => ['required', 'string', 'min:7', 'max:7'],
        'address'         => ['required', 'string', 'max:255'],
        'phone'           => ['required', 'string', 'max:14'],
        'width'           => ['nullable', 'min:1',  'max:7'],
        'age'             => ['nullable', 'string', 'min:1', 'max:5'],
        'nearest_station' => ['required', 'string', 'max:255'],
        'other_stations'  => ['nullable', 'string', 'max:255'],
        'rent'            => ['nullable', 'string', 'max:255'],
        'note'            => ['nullable', 'string', 'max:5000'],
        'contracted_at'   => ['required', 'date'],
        'occupancy_at'    => ['required', 'date'],
        'leaving_at'      => ['nullable', 'date'],
        'payment_date'    => ['nullable', 'string', 'max:3'],
        'status'                      => ['required', 'string'],
        'employment_insurance_number' => ['required', 'string', 'min:11', 'max:11'],
    ];

    protected $table = 'location';

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'contracted_at' => 'date',
        'occupancy_at'  => 'date',
        'leaving_at'    => 'date',
    ];

    /**
     * corpとのリレーション
     */
    public function corp()
    {
        return $this->belongsTo(Corp::class);
    }

    /**
     * departmentとのリレーション
     */
    public function department()
    {
        return $this->hasMany(Department::class);
    }

    /**
     * adminとのリレーション（location:id-department:location_id, department:id-admin:department_id）
     */
    public function admin()
    {
        return $this->hasManyThrough(Admin::class, Department::class);
    }

    /**
     * Equipmentとのリレーション
     */
    public function equipment()
    {
       return $this->hasOne(Equipment::class);
    }
}
