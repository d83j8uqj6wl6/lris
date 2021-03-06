<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Order;
use App\Model\Order_tag;
use App\Model\Personnel;
use App\Model\Material;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OwnOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    // public function getOwnOrderItem(Request $request)
    // {
    //     $data = Order_tag::where('develop_id',4)
    //     ->whereNotIn('develop_status',[10])
    //     ->select('tag_id','order_id','develop_status','estimated_time')
    //     ->with(["main" => function($q){
    //         $q->select('order_id','customer','order_num','item_num','item_name','reply_date',);
    //     }])
    //     ->with('personnel');

    //     $perPage = 10;
    //     $storeList =  $data ->skip($request->input('page') * $perPage);
    //     $paginate =  $storeList->paginate($perPage)->withPath(null)->toArray();
    //     $result = [];
    //     foreach ($paginate as $key => $item) {
    //         if (in_array($key, ['current_page', 'data', 'last_page', 'per_page', 'total'])) {
    //             $result[$key] = $item;
    //         }
    //     }
    //     return parent::jsonResponse([
    //         'lists' => $result
    //     ]);
    // }

    public function savePersonnel(Request $request)
    {
        Personnel::create([
            'tag_id'        => $request->tag_id,
            'leader'        => $request->leader,
            'difficulty'    => $request->difficulty ?: null,
        ]);
        $data = Order_tag::where('tag_id',$request->tag_id)->first();
        $data->estimated_time = Carbon::parse($request->estimated_time)->toDateTimeString();
        $data->start_time = Carbon::today();
        $data->develop_status = 8;
        $data->save();

        return parent::jsonResponse([
            'success' =>  'true'
        ]);
    }

    public function setOwnFinish(Request $request)
    {

        $data = Personnel::where('tag_id',$request->tag_id)->first();
        $data->name         = $request->name;
        $data->difficulty   = $request->difficulty;
        $data->save();

        $status = Order_tag::where('tag_id',$request->tag_id)->first();
        $status->end_time        = Carbon::today();
        $status->record          = $request->record;
        $status->develop_status  = 9;
        $status->save();

        return parent::jsonResponse([
            'success' =>  'true'
        ]);
    }

    public function confirm(Request $request)
    {
        $user = Auth::user();
        //???????????????
        if($user->lv !== 1){
            return parent::jsonResponse([
                'status' =>  'unPermission'
            ]);
        }
        
        $status = Order_tag::where('tag_id',$request->tag_id)->first();
        $day = carbon::parse ($status->end_time)->diffInDays($status->estimated_time, false); //?????????
        if($day >= 0){ //???????????????
            $expected = 14;
        }else{
            $expected = 15;
        }

        $status->develop_status = 10;
        $status->day = $day;
        $status->expected = $expected;
        $status->save();
        
        $count = Order_tag::where('order_id',$status->order_id)->whereNotIn('develop_status',[10])->count();
        if($count == 0){
            $order = Order::where('order_id',$status->order_id)->first();
            $order->develop_status = 10;
            $order->save();
        }

        return parent::jsonResponse([
            'status' =>  'success'
        ]);
    }

    public function getOwnOrderItem(Request $request)
    {
        if ($develop_status = $request->input('develop_status')) {
            $storeinfoexport = Order_tag::where('develop_id',4)
            ->whereNotIn('develop_status',[10])
            ->where('develop_status', $develop_status)
            ->select('tag_id','order_id','develop_status','estimated_time');    
        }else{
            $storeinfoexport = Order_tag::where('develop_id',4)
            ->whereNotIn('develop_status',[10])
            ->select('tag_id','order_id','develop_status','estimated_time');    
        }

        $datas = $storeinfoexport->with(["main" => function($q){
            $q->select(
                'order_id',
                'customer',
                'order_num',
                'item_num',
                'item_name',
                'order_date',
                'reply_date',
                'develop_status'
            );
        }])->whereHas('main',function($q)use($request){
            if ($order_num = $request->input('order_num')) {//????????????
                $q = $q->where('order_num', $order_num);
            }
            if ($item_num = $request->input('item_num')) {//??????
                $q = $q->where('item_num', $item_num);
            }
            if ($item_name = $request->input('item_name')) {//??????
                $q = $q->where('item_name', $item_name);
            }
            if ($order_date = $request->input('order_date')) {//????????????
                $q = $q->where('order_date', $order_date);
            }
            if ($reply_date = $request->input('reply_date')) {//?????????
                $q = $q->where('reply_date', $reply_date);
            }
        })
        ->with('personnel')->orderBy('reply_date','asc');

        $perPage = 10;
        $storeList =  $datas ->skip($request->input('page') * $perPage);
        $paginate = $storeList->paginate($perPage)->withPath(null)->toArray();
        $result = [];
        foreach ($paginate as $key => $item) {
            if (in_array($key, ['current_page', 'data', 'last_page', 'per_page', 'total'])) {
                $result[$key] = $item;
            }
        }

        return parent::jsonResponse([
            'lists' => $result
        ]);
    }
}
