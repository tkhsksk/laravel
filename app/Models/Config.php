<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $table = 'configs';

    protected $guarded = [];

    const RULES = [
        'site_name'    => ['required', 'string', 'max:255'],
        'mm_url'       => ['nullable', 'string', 'max:255'],
        'corp_holiday' => ['nullable', 'string', 'max:5000'],
    ];

    public static function getCorpHoliday($arr = '')
    {
        $new_arr = [];
        if($arr){
            $array = explode("\n", $arr);
            $array = array_map('trim', $array);
            $array = array_filter($array, 'strlen');
            $array = array_values($array);

            foreach($array as $in => $val){
                $vals = explode(':',$val);
                if(count($vals) == 2){
                    $new_arr[$vals[0]] = $vals[1];
                }
            }
        }

        return $new_arr;
    }
}
