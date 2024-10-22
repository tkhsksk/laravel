<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\User;
use App\Models\Location;
use App\Models\Admin;
use Illuminate\Http\Request;
use DB;

class EquipmentController extends Controller
{
    public function __construct()
    {
        // 未ログインはsigninにリダイレクト
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $equipments = Equipment::query();
        $keyword = $request->input('keyword');

        $conditions = [
            'admin_id' => $admin_id = $request->input('admin_id'),
            'category' => $category = $request->input('category'),
            'status'   => $status   = $request->input('status')
        ];

        if(!empty($keyword)) {
            $spaceConversion = mb_convert_kana($keyword, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) {
                $equipments
                ->where(DB::raw('CONCAT(number, portia_number)'), 'LIKE', "%{$value}%");
            }
            $keyword = implode(' ', $wordArraySearched);
        }

        foreach($conditions as $col => $val) {
            if(!empty($val)){
                $equipments
                ->where($col, '=', $val);
            }
        }

        return view('equipment.index', [
            'equipments' => $equipments->orderBy('created_at', 'desc')->paginate(10),
            'admins'     => getStatusEnable(new Admin),
            'keyword'    => $keyword,
            'admin_id'   => $admin_id,
            'category'   => $category,
            'status_req' => $status,
        ]);
    }

    public function detail(Request $request, $id = '')
    {
        $equipment = new Equipment;
        $equipment = Equipment::find($id);

        return view('equipment.detail', [
            'equipment' => $equipment,
        ]);
    }

    public function edit(Request $request, $id = '')
    {
        $equipment = new Equipment;
        $equipment = Equipment::find($id);

        return view('equipment.edit', [
            'equipment' => $equipment,
            'locations' => Location::all(),
            'admins'    => getStatusEnable(new Admin),
        ]);
    }

    public function confirm(Request $request)
    {
        $this->check($request);

        $inputs = $request->all();
        $name = getNamefromUserId($request->admin_id);

        return view('equipment.confirm', [
            'inputs' => $inputs,
            'name'   => $name,
        ]);
    }

    public function store(Request $request, $id = '')
    {
        $this->check($request);

        $equipment = new Equipment();
        $inputs    = $request->all();

        $equipment = Equipment::updateOrCreate(
            ['id' => $request->id],
            $inputs
        );

        return redirect('/equipment/detail/'.$equipment->id)->with('flash.success','機材を更新しました');
    }

    protected function ajax(Request $request)
    {
        $id     = $request->val;
        $admins = Location::find($id)->admin;

        foreach($admins as $admin)
        {
            $users[] = User::find($admin->id);
        }

        return response()->json($users);
    }

    protected function check(Request $request)
    {
        $credentials = $request->validate(Equipment::RULES);

        return null;
    }
}
