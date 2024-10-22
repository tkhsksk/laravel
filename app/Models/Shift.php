<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Models\Shift;

class Shift extends Model
{
    use HasFactory;

    const STATUS = [
        'N' => ['新規申請','primary','primary',3],
        'E' => ['承認済','success-new','success-new',2],
        'R' => ['申請無効','dark','light',1],
        //'H' => ['有給申請','danger','danger',0],
    ];

    const SORT = [
        0 => ['選択してください', ''],
        1 => ['出勤日数が多い順','days'],
        2 => ['月合計勤務時間が多い順','secs'],
    ];

    const CHOICES = [
        1 => [10,0,15,0],
        2 => [10,0,16,0],
        3 => [10,0,17,0],
    ];

    protected $table = 'shifts';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'preferred_date' => 'date',
    ];

    protected $guarded = [];

    protected function getTotalShifts($user_id, $year, $month)
    {
        $StartOfMonth = Carbon::parse($year.'-'.$month)->startOfMonth()->toDateString();
        $EndOfMonth   = Carbon::parse($year.'-'.$month)->endOfMonth()->toDateString();

        $shifts = Shift::query()
                    ->where('register_id', '=', $user_id)
                    ->where('status', '=', 'E')
                    ->whereBetween('preferred_date', [$StartOfMonth, $EndOfMonth]);

        return $shifts;
    }

    protected function getTotalShiftsTimes($shift_ids = [])
    {
        $diffInSecondsSum = 0;
        if($shift_ids){
            foreach($shift_ids as $shift_id){
                $shift   = Shift::find($shift_id);
                $date    = $shift->preferred_date->format('Y-m-d');
                $start_h = $shift->preferred_hr_st;
                $start_m = $shift->preferred_min_st;
                $end_h   = $shift->preferred_hr_end;
                $end_m   = $shift->preferred_min_end;

                $start = new Carbon($date.' '.$start_h.':'.sprintf('%02d', $start_m).':00');
                $end   = new Carbon($date.' '.$end_h.':'.sprintf('%02d', $end_m).':00');

                $diffInSeconds = $start->diffInSeconds($end);
                $diffInSecondsSum += $diffInSeconds;
            }
        }

        return $diffInSecondsSum;
    }
}
