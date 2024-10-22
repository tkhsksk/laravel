<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use App\Models\Department;
use App\Models\Corp;
use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LocationController extends Controller
{
    public function __construct()
    {
        // 未ログインはsigninにリダイレクト
        $this->middleware('auth');

        $this->disk = Storage::disk('protected');
    }

    public function index(Request $request)
    {
        $keyword   = $request->input('keyword');
        $status    = $request->input('status');

        if(!empty($status)) {
            $locations = Location::query();
        } else {
            $locations = Location::query()->where('status','U');// 初期ページでは社員のみ
        }

        if(!empty($keyword)) {
            $spaceConversion = mb_convert_kana($keyword, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) {
                $locations
                ->where('name', 'LIKE', "%{$value}%");
            }
            $keyword = implode(' ', $wordArraySearched);
        }

        return view('location.index', [
            'locations' => $locations->paginate(10),
            'users'     => User::all(),
            'keyword'   => $keyword,
            'status'    => $status,
        ]);
    }

    public function detail(Request $request, $id = '')
    {
        $location = new Location;
        $location = Location::find($id);

        $images = Files::query()
                  ->where('location_id',$id)
                  ->where('status','E')
                  ->Where(function($query){
                    $query
                    ->where('extension','png')
                    ->orWhere('extension','jpg')
                    ->orWhere('extension','jpeg');
                  })
                  ->orderBy('updated_at', 'desc');

        $files  = Files::query()
                  ->where('location_id',$id)
                  ->where('status','E')
                  ->Where(function($query){
                    $query
                    ->where('extension','pdf')
                    ->orWhere('extension','ai')
                    ->orWhere('extension','psd');
                  })
                  ->orderBy('updated_at', 'desc');

        return view('location.detail', [
            'location' => $location,
            'users'    => User::all(),
            'images'   => $images->paginate(20, ['*'], 'imagesPage'),
            'files'    => $files->paginate(10, ['*'], 'filesPage'),
        ]);
    }

    public function edit(Request $request, $id = '')
    {
        $location = new Location;
        $location = Location::find($id);

        return view('location.edit', [
            'location' => $location,
            'users'    => User::all(),
            'corps'    => getStatusEnable(new Corp),
        ]);
    }

    public function confirm(Request $request)
    {
        $this->check($request);

        $inputs = $request->all();

        return view('location.confirm', [
            'inputs' => $inputs,
        ]);
    }

    public function store(Request $request, $id = '')
    {
        $this->check($request);

        $inputs = $request->all();

        Location::updateOrCreate(
            ['id' => $request->id],
            $inputs
        );

        return redirect('/location/')->with('flash.success','オフィスを更新しました');
    }

    public function department(Request $request)
    {
        $department = new Department();

        $request->validate([
            'name'        => ['required','max:50'],
            'location_id' => ['required'],
        ]);

        Department::updateOrCreate(
            ['id' => $request->id],
            $request->all()
        );

        return redirect('/location/detail/'.$request->location_id)->with('flash.success','部署情報を登録しました');
    }

    public function media(Request $request)
    {
        $request->validate([
            'files'   => 'required',
            'files.*' => 'required|mimes:png,jpg,jpeg|max:1024',
        ]);

        $files = [];
        if ($request->file('files')){
            foreach($request->file('files') as $key => $file)
            {
                $fileName = time().Str::random(10).'.'.$file->getClientOriginalExtension();
                $files[$key]['size']        = $file->getSize();// getsizeはputFileAsの前に行う必要がある

                $path                       = $this->disk->putFileAs('location/'.$request->location_id, $file, $fileName);
                $files[$key]['url']         = '/protected/location/'.$request->location_id.'/'.$fileName;

                $files[$key]['register_id'] = Auth::user()->id;
                $files[$key]['name']        = $fileName;
                $files[$key]['origin_name'] = $file->getClientOriginalName();
                $files[$key]['location_id'] = $request->location_id;
                $files[$key]['extension']   = $file->getClientOriginalExtension();
            }
        }
    
        foreach ($files as $key => $file) {
            Files::create($file);
        }
       
        return back()
                ->with('flash.success','メディアを登録しました');
    }

    public function file(Request $request)
    {
        $request->validate([
            'files'   => 'required',
            'files.*' => 'required|mimes:pdf,ai,psd|max:10240',
        ]);

        $files = [];
        if ($request->file('files')){
            foreach($request->file('files') as $key => $file)
            {
                $fileName = time().Str::random(10).'.'.$file->getClientOriginalExtension();
                $files[$key]['size']        = $file->getSize();// getsizeはmoveの前に行う必要がある

                $path                       = $this->disk->putFileAs('location/'.$request->location_id, $file, $fileName);
                $files[$key]['url']         = '/protected/location/'.$request->location_id.'/'.$fileName;

                $files[$key]['register_id'] = Auth::user()->id;
                $files[$key]['name']        = $fileName;
                $files[$key]['origin_name'] = $file->getClientOriginalName();
                $files[$key]['location_id'] = $request->location_id;
                $files[$key]['extension']   = $file->getClientOriginalExtension();
            }
        }
    
        foreach ($files as $key => $file) {
            Files::create($file);
        }
       
        return back()
                ->with('flash.success','ファイルを登録しました');
    }

    protected function ajax(Request $request)
    {
        $id = $request->val;
        $department = Department::find($id);
        return response()->json($department);
    }

    protected function check(Request $request)
    {
        $credentials = $request->validate(Location::RULES);

        return null;
    }
}
