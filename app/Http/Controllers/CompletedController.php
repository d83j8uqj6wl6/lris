<?php

namespace App\Http\Controllers;

use App\Model\Order_tag;
use App\Model\Order;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class CompletedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function getCompletedItem(Request $request)
    {
        if ($develop_id = $request->input('develop_status')) {
            $storeinfoexport = Order_tag::where('develop_status',10)
            ->where('develop_id',$develop_id)
            ->select(
                'tag_id',
                'order_id',
                'develop_id',
                'develop_status',
                'estimated_time',
                'end_time',
                'expected',
                'day'
        );    
        }else{
            $storeinfoexport = Order_tag::where('develop_status',10)->select(
                'tag_id',
                'order_id',
                'develop_id',
                'develop_status',
                'estimated_time',
                'end_time',
                'expected',
                'day'
            );
        }

        if ($expected = $request->input('expected')) {//逾期
            $storeinfoexport = $storeinfoexport->where('expected', $expected);
        }

        $storeinfoexport->with(["main" => function($q){
            $q->select(
                'order_id',
                'customer',
                'order_num',
                'item_num',
                'item_name',
                'reply_date',
            );
        }])->whereHas('main',function($q)use($request){
            if ($order_num = $request->input('order_num')) {//採購號碼
                $q = $q->where('order_num', $order_num);
            }
            if ($item_num = $request->input('item_num')) {//品號
                $q = $q->where('item_num', $item_num);
            }
            if ($item_name = $request->input('item_name')) {//品名
                $q = $q->where('item_name', $item_name);
            }
            if ($order_date = $request->input('order_date')) {//單據日期
                $q = $q->where('order_date', $order_date);
            }
            if ($order_date = $request->input('order_date')) {//預交日期
                $q = $q->where('order_date', $order_date);
            }
            if ($reply_date = $request->input('reply_date')) {//回覆日
                $q = $q->where('reply_date', $reply_date);
            }
        })
        ->with('personnel')->whereHas('personnel',function($q)use($request){
            if ($name = $request->input('name')) {//負責人
                $q = $q->where('name', $name);
            }
        });
        $perPage = 10;
        $storeList =  $storeinfoexport ->skip($request->input('page') * $perPage);
        $paginate =  $storeList->paginate($perPage)->withPath(null)->toArray();
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

    // public function password(Request $request)
    // {

    //     $messages = [
    //         'password' => ['required', 'string', 'min:6', 'confirmed'],
    //     ];

    //     $validator = Validator::make($request->password);
    //     return $validator;



    //     $validator = Validator::make($request->all(), [
    //         'password' => ['required', 'string', 'min:6', 'confirmed'],
    //     ])->validate();
    //     return [$validator] ;
    //     $user = Auth::user();

    //     $aa = Hash::check($request->password, $user->password);
    //     if($aa){
    //         return 1;
    //     }else{
    //         return 2;
    //     }
    //     return [$aa];
    // }

    public function getDetail(Request $request)
    {
        // 帶入 develop_id  tag_id 
        if($request->develop_id == 5){
            $data = Order_tag::where('tag_id',$request->tag_id)
            ->select('tag_id','order_id','develop_id','price','start_time','end_time','estimated_time')->with(["personnel" => function($q){
                $q->select('tag_id','name');
            }])->get();    
        }
        else if($request->develop_id == 4){
            $data = Order_tag::where('tag_id',$request->tag_id)
            ->select('tag_id','order_id','develop_id','start_time','end_time','estimated_time','record')->with(["material" => function($q){
                $q->select('tag_id','material_id','length','width','high','unit_price','quantity','material');
            }])->with('personnel')->get();
        }

        return $data;
    }


}
