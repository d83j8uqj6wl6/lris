<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Order;
use App\Model\Order_tag;
use App\Model\Material;

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
        $storeinfoexport = Order::where('develop_status',7)->select(
            'order_id',
            'customer',
            'order_num',
            'order_date',
            'item_num',
            'item_name',
            'develop_id',
            'reply_date'
        )->orderBy('reply_date','asc');
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
        $data = Order::where('order_id',$request->order_id)->first();

        if($data->develop_id == 3){
            $data->delete();
            return parent::jsonResponse([
                'success' =>  'true'
            ]);
        }

        Order_tag::where('order_id',$request->order_id)->delete();
        $data->delete();
        
        return parent::jsonResponse([
            'success' =>  'true'
        ]);
    }

    public function setMode(Request $request)
    {
        $data = Order::where('order_id',$request->order_id)->first();
        $data->develop_id = $request->develop_id;
        $data->save();
        $order_id = $request->order_id;
        $develop_id = $request->develop_id;
        $reply_date = $data->reply_date;

        $dd = $this->add_child_order($order_id,$develop_id,$reply_date);
        

        return parent::jsonResponse([
            'success' => true
        ]);
    }
    
    private function add_child_order($order_id,$develop_id,$reply_date)
    {
        if($develop_id == 6){
            Order_tag::create([
                'order_id'          => $order_id,//訂單編號
                'develop_id'        => 4,
                'reply_date'        => $reply_date,
            ]);
            Order_tag::create([
                'order_id'          => $order_id,//訂單編號
                'develop_id'        => 5,
                'reply_date'        => $reply_date,
            ]);
        }else if($develop_id == 3){
            return null;
        }else{
            Order_tag::create([
                'order_id'          => $order_id,//訂單編號
                'develop_id'        => $develop_id,
                'reply_date'        => $reply_date,
            ]);
        }
    }

    public function createMaterial(Request $request)
    {
        $user = Auth::user();

        Material::create([
            'order_id'      => $request->order_id,
            'material_id'   => $request->material_id,
            'length'        => $request->length,
            'width'         => $request->width,
            'high'          => $request->high,
            'material'      => $request->material,
            'unit_price'    => $request->unit_price,
            'quantity'      => $request->quantity,
            'user_id'       => $user->id,
        ]);
        return parent::jsonResponse([
            'success' => true
        ]);
    }

    public function getMaterial(Request $request)
    {
        $data = Material::where('order_id',$request->order_id)->select(
            'aluminum_id',
            'order_id',
            'material_id',
            'length',
            'width',
            'high',
            'material',
            'unit_price',
            'quantity'
        )->first();
        return parent::jsonResponse([
            'data' => $data
        ]);
    }

    public function saveMaterialData(Request $request)
    {
        $data = Material::where('aluminum_id',$request->aluminum_id)->first();

        $data->material_id   = $request->material_id; 
        $data->length        = $request->length;
        $data->width         = $request->width;
        $data->high          = $request->high;
        $data->material      = $request->material;
        $data->unit_price    = $request->unit_price;
        $data->quantity      = $request->quantity; 
        $data->save();

        return parent::jsonResponse([
            'success' =>  'true'
        ]);
    }
}
