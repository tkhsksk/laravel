<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $guarded = [];

    protected $casts = [
        'started_at' => 'date',
        'ended_at'   => 'date',
        'created_at' => 'datetime',
    ];

    public static function getTimer($model = '')
    {
        $row = [];
        $row['start'] = '';
        $row['end'] = '';

        if($model){
            if($model->started_at){
                $row['start'] = $model->started_at;
                if($model->started_hr_at){
                    $row['start']->addHours($model->started_hr_at);
                    if($model->started_hr_at){
                        $row['start']->addMinutes($model->started_min_at);
                    }
                }
            }

            if($model->ended_at){
                $row['end'] = $model->ended_at;
                if($model->ended_hr_at){
                    $row['end']->addHours($model->ended_hr_at);
                    if($model->ended_min_at){
                        $row['end']->addMinutes($model->ended_min_at);
                    }
                }
            }
        }

        return $row;
    }

    public static function getPeriod($db)
    {
        $priod = '';

        if($db->started_at){
            $priod .= $db->started_at->isoFormat('Y/M/D(ddd)');
            if($db->started_hr_at){
                $priod .= '<br />'.$db->started_hr_at;
                $priod .= ':'.sprintf('%02d', $db->started_min_at);
            }
        } else {
            $priod .= '現在時刻';
        }
        $priod .= '<p class="mb-0 px-2">〜</p>';

        if($db->ended_at){
            $priod .= $db->ended_at->isoFormat('Y/M/D(ddd)');
            if($db->ended_hr_at){
                $priod .= '<br />'.$db->ended_hr_at;
                $priod .= ':'.sprintf('%02d', $db->ended_min_at);
            }
        } else {
            $priod .= 'ずっと';
        }

        return $priod;
    }

    protected function getQuery()
    {
        $now   = new Carbon('now');
        $today = new Carbon('today');

        return self::query()
                ->where(
                    // 開始日ありだけでこんなに長いの・・
                    function ($query) use($now, $today) {
                        $query
                        ->where('started_at', '<', $today)
                        ->orWhere(
                            function ($query) use($now, $today) {
                                $query
                                ->where('started_at', '=', $today)
                                ->whereNull('started_hr_at');
                            }
                        )
                        ->orWhere(
                            function ($query) use($now, $today) {
                                $query
                                ->where('started_at', '=', $today)
                                ->where('started_hr_at', '<', intval($now->format('H')))
                                ->orWhere(
                                    function ($query) use($now, $today) {
                                        $query
                                        ->where('started_hr_at', '=', intval($now->format('H')))
                                        ->where('started_min_at', '<=', intval($now->format('i')));
                                    }
                                );
                            }
                        )
                        ->orWhereNull('started_at');
                    }
                )
                ->where(
                    // 開始日なし
                    function ($query) use($now, $today) {
                        $query
                        ->where('ended_at', '>', $today)
                        ->orWhere(
                            function ($query) use($now, $today) {
                                $query
                                ->where('ended_at', '=', $today)
                                ->whereNull('ended_hr_at');
                            }
                        )
                        ->orWhere(
                            function ($query) use($now, $today) {
                                $query
                                ->where('ended_at', '=', $today)
                                ->where('ended_hr_at', '>', intval($now->format('H')))
                                ->orWhere(
                                    function ($query) use($now, $today) {
                                        $query
                                        ->where('ended_hr_at', '=', intval($now->format('H')))
                                        ->where('ended_min_at', '>=', intval($now->format('i')));
                                    }
                                );
                            }
                        )
                        ->orWhereNull('ended_at');
                    }
                )
                ->where('status', 'E');
    }
    
}
