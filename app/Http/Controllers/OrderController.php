<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Admin;
use App\Models\Order;

class OrderController extends Controller
{
    public function __construct()
    {
        // 未ログインはsigninにリダイレクト
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $orders = Order::query();

        $conditions = [
            'register_id' => $register_id = $request->input('register_id'),
            'charger_id'  => $charger_id  = $request->input('charger_id'),
            'status'      => $status      = $request->input('status')
        ];

        if(!empty($keyword)) {
            $spaceConversion = mb_convert_kana($keyword, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) {
                $orders
                ->where('question', 'LIKE', "%{$value}%");
            }
            $keyword = implode(' ', $wordArraySearched);
        }

        foreach($conditions as $col => $val) {
            if(!empty($val)){
                $orders
                ->where($col, '=', $val);
            }
        }

        return view('order.index', [
            'keyword'    => $keyword,
            'admins'     => getStatusEnable(new Admin),
            'conditions' => $conditions,
            'orders'     => $orders->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    public function detail(Request $request, $id = '')
    {
        $order = new Order;
        $order = Order::find($id);

        return view('order.detail', [
            'order' => $order,
        ]);
    }

    public function edit(Request $request, $id = '')
    {
        $order    = new Order;
        $order    = Order::find($id);
        $statuses = Order::STATUS;

        // ステータスの操作
        if($order)
            if($order->status == 'N'){
                unset($statuses['E']);
            } elseif($order->status == 'P'){
                unset($statuses['K']);
            } elseif ($order->status == 'E') {
                unset($statuses['N']);
                unset($statuses['K']);
            } elseif ($order->status == 'E') {
                unset($statuses['N']);
            }

        return view('order.edit', [
            'order'    => $order,
            'admins'   => Admin::all(),
            'statuses' => $statuses,
        ]);
    }

    public function confirm(Request $request)
    {
        $this->check($request);

        $inputs = $request->all();

        return view('order.confirm', [
            'inputs' => $inputs,
        ]);
    }

    public function store(Request $request, $id = '')
    {
        $order = new Order();

        if($request->id) {
            if(in_array(Order::find($request->id)->status, ['N','K'])){
                if($request->status == 'P'){
                    $request->merge(['purchase_at' => \Carbon\Carbon::now()]);// 購入日の更新
                }
            }

            if(Order::find($request->id)->status == 'P'){
                if($request->status == 'E'){
                    $request->merge(['arrival_at' => \Carbon\Carbon::now()]);// 到着日の更新
                }
            }
        } else {
            Cookie::queue(Cookie::forget('default_charger'));
            Cookie::queue('default_charger', $request->charger_id,  1209600);// 二週間保存
        }

        $inputs = $request->all();

        $order = Order::updateOrCreate(
            ['id' => $request->id],
            $inputs
        );

        return redirect('/order/')->with('flash.success','購入リクエストを更新しました');
    }

    protected function check(Request $request)
    {
        $credentials = $request->validate(Order::RULES);

        return null;
    }
}
