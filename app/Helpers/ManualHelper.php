<?php

// 文字数から購読時間を取得
function getReadTime($txt)
{
    // 人が文字を読む速度を1分につき550文字とする
    $read = 550;

    if(($time = mb_strlen($txt) / $read) < 1){
        return '1分以内';
    } elseif($time >= 1 && $time < 60) {
        return round($time).'分';
    } else {
        return floor($time / 60).'時間'.round(($time / 60 - floor($time / 60))*60).'分';
    }
}

function getFirstImage($post)
{
     $first_post_image_url = '';
     preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/',$post, $matches);
     if(count($matches) > 0){
        $first_post_image_url = $matches[1];
     }

     return $first_post_image_url;
}