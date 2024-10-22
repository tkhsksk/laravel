<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;

class Equipment extends Model
{
    use HasFactory;

    const EQUIPMENT_CATEGORIES = [
        'P' => ['デスクトップPC','🖥'],
        'L' => ['ラップトップPC','💻'],
        'K' => ['キーボード','⌨'],
        'D' => ['ディスプレイ','🖥'],
        'M' => ['マウス','🖱'],
        'E' => ['その他機材','⚙️']
    ];

    const EQUIPMENT_STATUS = [
        'U' => ['使用中','text-bg-success'],
        'N' => ['未使用','text-bg-danger'],
        'D' => ['破棄','text-bg-dark'],
    ];

    const RULES = [
        'number'       => ['required', 'string', 'max:255'],
        'price'        => ['nullable', 'string', 'min:1', 'max:12'],
        'status'       => ['required', 'string'],
        'location_id'  => ['required'],
        'purchased_at' => ['required', 'date'],
        'os'           => ['nullable', 'string', 'max:255'],
        'os_version'   => ['nullable', 'string', 'max:255'],
        'display_size' => ['nullable', 'string', 'min:1', 'max:5'],
        'memory'       => ['nullable', 'string', 'max:255'],
        'storage'      => ['nullable', 'string', 'max:255'],
        'processor'    => ['nullable', 'string', 'max:255'],
        'portia_number'=> ['required', 'string', 'max:255'],
        'note'         => ['nullable', 'string', 'max:5000'],
    ];

    protected $table = "equipments";

    protected $casts = [
        'purchased_at' => 'datetime',
        'used_at'      => 'date',
    ];

    protected $guarded = [];

    /**
     * adminとのリレーション
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * locationとのリレーション
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
