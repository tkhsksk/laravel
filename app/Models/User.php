<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Admin;
use App\Models\Equipment;
use App\Rules\RuleKana;

// modelの作成
// php artisan make:model ほにゃらら

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";

    const TABS = [
        'profile'  => ['あなたのメモ帳','ph ph-notepad'],
        'shift'    => ['シフト履歴','ph ph-clock-user'],
        'favorite' => ['ブックマークしたマニュアル','ph ph-heart-straight'],
        'personal' => ['あなたの個人情報','ph ph-detective'],
    ];

    const HOW_TO_COMMUTE = [
        'T' => '電車',
        'B' => 'バス',
        'W' => '徒歩',
        'C' => '自転車',
        'M' => '車',
        'E' => 'その他'
    ];

    const SPOUSE_STATUS = [
        'T' => 'あり',
        'F' => 'なし'
    ];

    const BANK_STATUS = [
        'D' => '普通口座',
        'C' => '当座口座'
    ];

    const GENDER_STATUS = [
        'M' => '男性',
        'F' => '女性'
    ];

    const BANK_LIST = ['みずほ','三菱UFJ','三井住友','りそな','きらぼし'];

    public function rules()
    {
        return [
            'first_name'           => ['required', 'form', 'max:50'],
            'second_name'          => ['required', 'form', 'max:50'],
            'first_kana'           => ['required', 'form', 'max:50', new RuleKana],
            'second_kana'          => ['required', 'form', 'max:50', new RuleKana],
            'birthday'             => ['required', 'group'],
            'post'                 => ['required', 'group', 'max:10'],
            'address'              => ['required', 'group', 'max:100'],
            'phone'                => ['required', 'group', 'max:20', 'regex:/^[0-9]+$/'],
            'spouse_status'        => ['required', 'radio'],
            'dependent'            => ['nullable', 'group', 'max:2'],

            'gender'               => ['required', 'radio'],

            'name'                 => ['required', 'form', 'max:50'],
            'image'                => ['nullable', 'form', 'mimes:jpg,jpeg,png', 'max:500'],

            'how_to_commute'       => ['required', 'form'],
            'nearest_station'      => ['required', 'group', 'max:100'],
            'nearest_station_corp' => ['required', 'group', 'max:100'],

            'bank_name'              => ['required', 'group', 'max:30'],
            'bank_number'            => ['required', 'form', 'max:30'],
            'bank_branch_name'       => ['required', 'group', 'max:30'],
            'bank_branch_number'     => ['required', 'form', 'max:30'],
            'bank_account_status'    => ['required', 'radio'],
            'bank_account'           => ['required', 'group', 'max:30'],
            'bank_account_name'      => ['required', 'group', 'max:30'],
            'bank_account_name_kana' => ['required', 'group', 'max:30'],

            'emoji_mm'             => ['nullable', 'group'],
            'adobe_account'        => ['nullable', 'form', 'email'],
            'adobe_pass'           => ['nullable', 'form'],
        ];
    }

    protected function getRequiredJs()
    {
        $required_arr = '';

        foreach ($this->rules() as $key => $value) {
            if($value[0] == 'required')
                $required_arr .= $key.':{required:true},';
        }

        return rtrim( $required_arr,',' );
    }

    protected function getRequiredPlacementJs()
    {
        $required_arr = '';

        foreach ($this->rules() as $key => $value) {
            if($value[1] == 'group')
                $required_arr .= "element.is('[name=\"".$key."\"]')||";
        }

        return rtrim( $required_arr,'||' );
    }

    protected function setValidateForUser()
    {
        $input_type = $this->rules();
        // バリデーションに不要な要素を削除
        foreach($input_type as $i => $required){
            $input_type[$i][1] = null;
        }
        return $input_type;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     * dateやpasswordなど文字列として取得したくないもの
     */
    protected $casts = [
        'password'    => 'hashed',
        'birthday'    => 'date',
        'signedin_at' => 'datetime',
    ];

    public static function user() {
        return User::get();
    }

    /**
     * Adminとのリレーション
     */
    public function admin()
    {
        // hasManyも可能
        return $this->hasOne(Admin::class);
    }

    /**
     * equipmentとのリレーション
     */
    public function equipment()
    {
        return $this->hasManyThrough(Equipment::class, Admin::class);
    }
}
