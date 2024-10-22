<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Site;
use App\Models\Server;
use App\Models\Admin;
use App\Models\User;
use App\Models\Database;
use DB;

class SiteController extends Controller
{
    public function __construct()
    {
        // 未ログインはsigninにリダイレクト
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $status  = $request->input('status');

        if(!empty($status)) {
            $sites = Site::query();
        } else {
            $sites = Site::query()->where('status','E');// 初期ページでは有効のみ
        }

        if(!empty($keyword)) {
            $spaceConversion = mb_convert_kana($keyword, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) {
                $sites
                ->where(DB::raw('CONCAT(url, name)'), 'LIKE', "%{$value}%");
            }
            $keyword = implode(' ', $wordArraySearched);
        }

        return view('site.index', [
            'sites'   => $sites->orderBy('created_at', 'desc')->paginate(12),
            'keyword' => $keyword,
            'status'  => $status,
        ]);
    }

    public function detail(Request $request, $id = '')
    {
        $site = new Site;
        $site = Site::find($id);

        return view('site.detail', [
            'site'  => $site,
        ]);
    }

    public function edit(Request $request, $id = '')
    {
        $site = new Site;
        $site = Site::find($id);

        return view('site.edit', [
            'site'    => $site,
            'dsites'  => getStatusEnable(new Site),
            'dbs'     => getStatusEnable(new Database),
            'servers' => getStatusEnable(new Server),
        ]);
    }

    public function confirm(Request $request)
    {
        $this->check($request);

        $inputs = $request->all();

        return view('site.confirm', [
            'inputs' => $inputs,
        ]);
    }

    public function store(Request $request, $id = '')
    {
        $this->check($request);

        $inputs = $request->all();

        Site::updateOrCreate(
            ['id' => $request->id],
            $inputs
        );

        return redirect('/site/')->with('flash.success','サイトを更新しました');
    }

    // サーバー
    public function indexServer(Request $request)
    {
        $keyword = $request->input('keyword');
        $status  = $request->input('status');

        if(!empty($status)) {
            $servers = Server::query();
        } else {
            $servers = Server::query()->where('status','E');// 初期ページでは有効のみ
        }

        if(!empty($keyword)) {
            $spaceConversion = mb_convert_kana($keyword, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) {
                $servers
                ->where(DB::raw('CONCAT(url, name)'), 'LIKE', "%{$value}%");
            }
            $keyword = implode(' ', $wordArraySearched);
        }

        return view('server.index', [
            'servers' => $servers->paginate(10),
            'keyword'     => $keyword,
            'status'      => $status,
        ]);
    }

    public function detailServer(Request $request, $id = '')
    {
        $server = new Server;
        $server = Server::find($id);

        return view('server.detail', [
            'server'  => $server,
        ]);
    }

    public function editServer(Request $request, $id = '')
    {
        $server = new Server;
        $server = Server::find($id);

        return view('server.edit', [
            'server'    => $server,
        ]);
    }

    public function confirmServer(Request $request)
    {
        $this->checkServer($request);

        $inputs = $request->all();

        return view('server.confirm', [
            'inputs' => $inputs,
        ]);
    }

    public function storeServer(Request $request, $id = '')
    {
        $this->checkServer($request);

        $inputs = $request->all();

        Server::updateOrCreate(
            ['id' => $request->id],
            $inputs
        );

        return redirect('/server/')->with('flash.success','サーバーを更新しました');
    }

    // データベース
    public function indexDatabase(Request $request)
    {
        $keyword = $request->input('keyword');
        $status  = $request->input('status');

        if(!empty($status)) {
            $databases = Database::query();
        } else {
            $databases = Database::query()->where('status','E');// 初期ページでは有効のみ
        }

        if(!empty($keyword)) {
            $spaceConversion = mb_convert_kana($keyword, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) {
                $databases
                ->where(DB::raw('CONCAT(phpmyadmin, host)'), 'LIKE', "%{$value}%");
            }
            $keyword = implode(' ', $wordArraySearched);
        }

        return view('database.index', [
            'databases' => $databases->paginate(10),
            'keyword'     => $keyword,
            'status'      => $status,
        ]);
    }

    public function detailDatabase(Request $request, $id = '')
    {
        $database = new Database;
        $database = Database::find($id);

        return view('database.detail', [
            'database' => $database,
        ]);
    }

    public function editDatabase(Request $request, $id = '')
    {
        $database = new Database;
        $database = Database::find($id);

        return view('database.edit', [
            'database' => $database,
            'servers'  => getStatusEnable(new Server),
        ]);
    }

    public function confirmDatabase(Request $request)
    {
        $this->checkDatabase($request);

        $inputs = $request->all();

        return view('database.confirm', [
            'inputs' => $inputs,
        ]);
    }

    public function storeDatabase(Request $request, $id = '')
    {
        $this->checkDatabase($request);

        $inputs = $request->all();

        Database::updateOrCreate(
            ['id' => $request->id],
            $inputs
        );

        return redirect('/database/')->with('flash.success','データベースを更新しました');
    }

    protected function check(Request $request)
    {
        $credentials = $request->validate(Site::RULES);

        return null;
    }

    protected function checkServer(Request $request)
    {
        $credentials = $request->validate(Server::RULES);

        return null;
    }

    protected function checkDatabase(Request $request)
    {
        $credentials = $request->validate(Database::RULES);

        return null;
    }

    protected function ajax(Request $request)
    {
        $id = $request->val;
        $site = Site::find($id);
        return response()->json($site);
    }
}
