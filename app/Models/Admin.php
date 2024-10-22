<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Equipment;
use App\Models\Location;
use App\Models\Department;

class Admin extends Model
{
    use HasFactory;

    const ADMIN_MENU_TABS = [
        'admin'     => ['管理者','ph ph-user'],
        'other'     => ['保険他','ph ph-hospital'],
        'account'   => ['アカウント','ph ph-password'],
        'equipment' => ['機材','ph ph-desktop'],
        'profile'   => ['ユーザー(編集不可)','ph ph-users-three'],
        'file'      => ['ファイル','ph ph-folder-simple-user'],
    ];

    const ADMIN_STATUS = [
        'E' => ['有効','text-bg-success','甲','有り'],
        'D' => ['無効','text-bg-danger', '乙','無し'],
    ];

    const ADMIN_ROLES = [
        'M' => ['マスター','マスター以上で閲覧可能'],
        'A' => ['管理者','管理者以上で閲覧可能'],
        'B' => ['一般','だれでも閲覧可能'],
    ];

    const RULES_ADMIN = [
        'user_id'       => ['required'],
        'code'          => ['required', 'min:6', 'max:6'],
        'employment_id' => ['required'],
        'role'          => ['required'],
        'location_id'   => ['required'],
        'department_id' => ['required'],
        'title'         => ['required'],
        'employed_at'   => ['required'],
        'started_at'    => ['required'],
    ];

    const RULES_OTHER = [
        'insurance_employment_number' => ['required', 'min:11', 'max:11'],
    ];

    const RULES_ACCOUNT = [
        'mm_name'             => ['required', 'string', 'max:255'],
        'mm_pass'             => ['required', 'string', 'max:255'],
        'google_account'      => ['required', 'string', 'max:255'],
        'google_account_pass' => ['required', 'string', 'max:255'],
        'pin'                 => ['required', 'min:4',  'max:4'],
        'win_device_name'     => ['nullable', 'string', 'max:255'],
        'ms_account'          => ['nullable', 'string', 'max:255'],
        'ms_account_password' => ['nullable', 'string', 'max:255'],
        'apple_id'            => ['nullable', 'string', 'max:255'],
        'apple_pass'          => ['nullable', 'string', 'max:255'],
        'mac_name'            => ['nullable', 'string', 'max:255'],
        'mac_account_name'    => ['nullable', 'string', 'max:255'],
        'mac_account_pass'    => ['nullable', 'string', 'max:255'],
    ];

    protected $table = "user_admins";

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'started_at'  => 'date',
        'employed_at' => 'date',
    ];

    public static function getAdmin($user_id)
    {
        return Admin::where('user_id', $user_id)->first();
    }

    /**
     * Userとのリレーション
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Departmentとのリレーション
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Equipmentとのリレーション
     */
    public function equipment(): HasMany
    {
       return $this->hasMany(Equipment::class);
    }


}
