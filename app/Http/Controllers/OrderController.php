<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Create a new AuthController instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function addOrder(Request $request)
    {
        $user = Auth::user();
        
        Order::create([
            'customer'          => $request->customer,
            'order_num'         => $request->order_num,
            'order_date'        => Carbon::parse($request->order_date)->toDateTimeString(),
            'item_num'          => $request->item_num,
            'item_name'         => $request->item_name,
            'quantity'          => $request->quantity,
            'pre_delivery_data' => Carbon::parse($request->pre_delivery_data)->toDateTimeString(),
            'reply_date'        => Carbon::parse($request->reply_date)->toDateTimeString(),
            'user_id'           => $user->id
        ]);
        return parent::jsonResponse([
            'success' => true
        ]);
    }

    public function getOrderItem(Request $request)
    {
        $storeinfoexport = Order::where('develop_status',0)->select('customer', 'order_num','order_date','item_num','item_name','develop_id','reply_date')->orderBy('reply_date');
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

    public function getOrderData(Request $request)
    {
        $data = Order::where('order_id',$request->order_id)->get();
        return parent::jsonResponse([
            'data' => $data
        ]);
    }

    public function saveOrderData(Request $request)
    {
        $data = Order::where('order_id',$request->order_id)->first();

        $data->order_num            = $request->order_num; //採購號碼
        $data->order_date           = Carbon::parse($request->order_date)->toDateTimeString();//單據日期 ,
        $data->item_num             = $request->item_num;//品號
        $data->item_name            = $request->item_name;//品名
        $data->quantity             = $request->quantity;//數量
        $data->pre_delivery_data    = Carbon::parse($request->pre_delivery_data)->toDateTimeString();//預交日期
        $data->reply_date           = Carbon::parse($request->reply_date)->toDateTimeString(); //回覆日期
        $data->save();

        return parent::jsonResponse([
            'success' =>  'true'
        ]);
    }

    public function delOrderData(Request $request)
    {
        $data = Order::where('order_id',$request->order_id)->delete();
        return parent::jsonResponse([
            'success' =>  'true'
        ]);
    }
}
