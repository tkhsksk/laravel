<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Shift;
use App\Models\Corp;
use App\Models\Order;
use App\Models\Notification;
use App\Models\Favorite;
use App\Models\Config;
use App\Models\Department;

// 誕生日から年齢を取得
function getAgefromBirthday($birthday)
{
    $age = '';
    if($birthday){
        $birthday_replace = $birthday->format('Ymd');
        $age = floor((Carbon::now()->format('Ymd') - $birthday_replace) / 10000);
    }

    return $age;
}

// idから名前を取得
function getNamefromUserId($id, $type = '')
{
    $name  = '';
    $user  = User::find($id);
    $admin = Admin::where('id', $id)->first();
    $role  = Admin::where('id', Auth::user()->id)->first()->role;

    if($user && $admin->status != 'D'){
        $name = $user->first_name ? $user->first_name.' '.$user->second_name : $user->name;// userのfirst_nameが登録されている時は氏名を返す
        $name = $role=='B' ? $user->name : $name;// 権限が一般の場合はニックネームを返す
    } else {
        if(isset($user)){
            $name = '無効なユーザー：id'.$user->id;
        } else {
            $name = 'ユーザーが存在しません';
        }
    }

    if($type == 'A'){
        if(Auth::user()->id == $id){
            return $role=='B' ? $user->name.'（あなた）' : $name.'（あなた）';
        } else {
            $name = $role=='B' ? $user->name : $name;// 権限が一般の場合のみニックネームを返す、それ以外はフルネーム
        }
    }

    if($type == 'U'){
        if(Auth::user()->id == $id){
            return $user->name.'（あなた）';
        } else {
            return $user->name;// 権限に関わらずニックネームを返す
        }
    }

    if($type == 'F'){
        if(Auth::user()->id == $id){
            return $user->name.'（あなた）';
        } else {
            if($user->first_name){
                return $user->first_name;
            } else {
                return $user->name;// 権限に関わらずfirst_nameを返す
            }
        }
    }

    return $name;
}

function getUserImage($id)
{
    $image = '';
    $user  = User::find($id);

    if($user)
        $image = $user->image ?? asset('/thumb/no-user.jpeg');
    else
        $image = asset('/image/user-1.png');

    return $image;
}

function getStatus($ena, $dis, $status = '')
{
    if($status == 'E' || $status == true){
        $badge = 'success';
        $text = $ena;
    }
    if($status == 'D'){
        $badge = 'danger';
        $text = $dis;
    }

    return '<span class="text-bg-'.$badge.' p-1 rounded-circle"></span><p class="mb-0 ms-2">'.$text.'</p>';
}

function formatYmd($date)
{
    if($date){
        return $date->format('Y-m-d');
    }
    return null;
}

function cryptDecrypt($pass)
{
    if($pass){
        return Crypt::decrypt($pass);
    }
    return null;
}

function getPost($post)
{
    return substr($post,0,3).'-'.substr($post,3);
}

function getCorpName($id)
{
    $corp = '';
    $corp = Corp::find($id);
    $corpName = $corp->name;

    if($corp->status != 'E'){
        $corpName = '無効な企業：id'.$corp->id;
    }

    return $corpName;
}

function getSiteDatas($url)
{
    $ch = curl_init();
    // curl_setopt($ch, CURLOPT_USERPWD, 'pay' .":". '9SxWM9qH');
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36');
    $result = curl_exec($ch);
    curl_close($ch);

    preg_match('/<title>([^<]+)<\/title>/', $result, $title);
    preg_match('#og:image["\'].*?content=["\'](.*?)["\']#', $result, $ogp);
    
    if(isset($title[1]) && $title[1] == '401 Unauthorized' || !isset($title[1])){
        $title[1] = $url;
    }

    if(isset($ogp[1])){
        return [
            'ogpimg' => htmlspecialchars_decode($ogp[1]),
            'title'  => $title[1]
        ];
    }

    return [
        'ogpimg' => asset('/thumb/no-bg.svg'),
        'title'  => $title[1]
    ];
}

function getDateLimit($date,$hour = '',$min = '')
{
    $time = '';
    if($hour){
        $time .= ','.$hour;
    }
    if($min){
        $time .= ':'.$min;
    }

    $diff = Carbon::now()->format('Ymd') - (new Carbon($date))->format('Ymd');
    if($diff == 0){
        return '今日'.$time;
    } elseif($diff == -1) {
        return '明日'.$time;
    } elseif($diff > 0) {
        return '期限を過ぎています';
    }

    return (new Carbon($date))->isoFormat('YYYY/M/D(ddd)').$time;
}

function getShiftTime($id = '')
{
    $shift = Shift::find($id);
    return $shift->preferred_hr_st.':'.sprintf('%02d', $shift->preferred_min_st).'〜'.$shift->preferred_hr_end.':'.sprintf('%02d', $shift->preferred_min_end);
}

function getInsuranceNumber($num)
{
    return substr($num,0,4).'-'.substr($num,4,6).'-'.substr($num,10,1);
}

function getStatusEnable($model)
{
    if($model == new Admin){
        // Adminから取得する場合は、先頭にログインユーザー持ってくる
        $query = $model::query()->orderByRaw('id='.Auth::user()->id.' desc');
    } else {
        $query = $model::query();
    }
    
    return $query->where('status','E')->get();
}

function byteFormat($size=0, $units=['byte','KB','MB','GB','TB']): string
{
    for ($i = 0; 1024 < $size; $i++) {
        $size /= 1024;
    }
    return round($size) . ' ' . $units[$i];
}

function getSelectableRole()
{
    $authRole = Auth::user()->admin->role;
    $roles = [];
    foreach(array_reverse(Admin::ADMIN_ROLES) as $in => $role){
        $roles[$in]['label'] = $role[1];
        if($authRole == $in){
            break;
        }
    }
    return $roles;
}

// 特定の権限までの配列を取得する
function getArrToRole($roles, $targetRole)
{
    $arr = [];
    foreach($roles as $in => $role){
        $arr[] = $in;
        if($targetRole === $in){
           break;
        }
    }

    return $arr;
}

function getUserOrders($num = '')
{
    $id = '';
    $orders = Order::query()
                ->where('register_id', '=', Auth::user()->id)
                ->where('status', '=', 'N')
                ->orderBy('updated_at', 'desc');

    if($num) {
        $orders = $orders->take($num);
    }

    return $orders->get();
}

function getRecentNotices($num = '')
{
    $today = new Carbon('today');
    $roles = getArrToRole(array_reverse(Admin::ADMIN_ROLES), Auth::user()->admin->role);

    $notices = Notification::getQuery($roles)
                ->whereIn('role', $roles)
                ->orderBy('created_at', 'desc');

    if($num) {
        $notices = $notices->take($num);
    }

    return $notices->get();
}

function searchFromTo($query, $col, $from = '', $to = '')
{
    if($to) {
        $toDate = new Carbon($to);
        $toDate = $toDate->addDays(1);
    }

    if($from) {
        if($to) {
            $query->whereBetween($col, [$from, $toDate]);
        } else {
            $query->where($col, '>=', $from);
        }
    } elseif($to) {
        $query->where($col, '<=', $toDate);
    }

    return $query;
}

function isFavorite($type, $id)
{
    $favorite = Favorite::query()
                    ->where('contents_id', '=', $id)
                    ->where('register_id', '=', Auth::user()->id)
                    ->where('type', '=', $type)
                    ->first();

    if($favorite){
        return $favorite->id;
    } else {
        return null;
    }
}

function getHolidays($add = '')
{
    $url        = 'https://holidays-jp.github.io/api/v1/date.json';
    $holiDays   = [];
    if($data = @file_get_contents($url)){
        $json     = file_get_contents($url);
        $json     = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $holiDays = json_decode($json,true);
    }
    $corpHoliDays = Config::getCorpHoliday(Config::find(1)->corp_holiday);
    $holiDays = array_merge($holiDays, $corpHoliDays);

    if($add){
        $holiDays = array_merge($holiDays,$add);
    }

    return $holiDays;
}

function getHourMinute($second)
{
    $hours   = floor($second / 3600);
    $minutes = floor(($second % 3600) / 60);

    return $hours.':'.sprintf('%02d', $minutes);
}