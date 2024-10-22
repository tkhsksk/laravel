<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Server;

class Site extends Model
{
    use HasFactory;
    protected $table = 'sites';
    protected $guarded = [];

    const RULES = [
        'name'       => ['nullable', 'string', 'max:255'],
        'url'        => ['required', 'string', 'max:255'],
        'url_admin'  => ['nullable', 'string', 'max:255'],
        'basic_id'   => ['nullable', 'string', 'max:255'],
        'basic_pass' => ['nullable', 'string', 'max:5000'],
        'git'        => ['nullable', 'string', 'max:5000'],
        'note'       => ['nullable', 'string', 'max:5000'],
    ];

    public static function getServer($id = '')
    {
        if($id){
            $server = Server::find($id);
            return '<a href="/server/detail/'.$id.'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="詳細画面へ">'.$server->name.'（'.$server->plan.'）</a><a href="'.$server->url.'" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="サーバーのurlを開く"><i class="ph ph-link-simple"></i></a>';
        } else {
            return '未登録';
        }
    }

    public static function getDatabase($id = '')
    {
        if($id){
            $database = Database::find($id);
            return '<a href="/database/detail/'.$id.'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="詳細画面へ" class="me-2">'.$database->host.'('.$database->user.')</a><a href="'.$database->phpmyadmin.'" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="phpmyadmin"><i class="ph ph-link-simple"></i></a>';
        } else {
            return '未登録';
        }
    }

    public static function getSite($id = '')
    {
        if($id){
            $site = Site::find($id);
            $sitename = '';
            if($site->name){
                $sitename = $site->name;
            } else {
                $sitename = getSiteDatas($site->url)['title'];
            }
            return '<a href="/site/detail/'.$id.'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="詳細画面へ" class="me-2">'.$sitename.'</a><a href="'.$site->url.'" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="サイトを開く"><i class="ph ph-link-simple"></i></a>';
        } else {
            return '未登録';
        }
    }
}
