<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Order_tag;
use App\Model\Personnel;
use App\Model\Order;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class OutsourceOrderController extends Controller
{
    public function getOutsourceOrderItem(Request $request)
    {
        $data = Order_tag::where('develop_id',5)->whereNotIn('develop_status',[10])->select('tag_id','order_id','develop_status','estimated_time','price')->with(["main" => function($q){
            $q->select('order_id','customer','order_num','item_num','item_name','reply_date',);
        }])->with('personnel');

        $perPage = 10;
        $storeList =  $data ->skip($request->input('page') * $perPage);
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

    public function saveOutsourcePersonnel(Request $request)
    {
        $user = Auth::user();

        Personnel::create([
            'tag_id'        => $request->tag_id,
            'leader'        => $request->leader ?: $user->id,
            'name'          => $request->name,
            'difficulty'    => $request->difficulty ?: null,
        ]);
        $data = Order_tag::where('tag_id',$request->tag_id)->first();
        $data->estimated_time   = Carbon::parse($request->estimated_time)->toDateTimeString();
        $data->price            = $request->price;
        $data->quantity         = $request->quantity;
        $data->start_time       = Carbon::today();
        $data->develop_status   = 8;
        $data->save();

        return parent::jsonResponse([
            'success' =>  'true'
        ]);
    }

    public function setOutsourceFinish(Request $request)
    {
        $status = Order_tag::where('tag_id',$request->tag_id)->first();
        $status->end_time        = Carbon::today();
        $status->record          = $request->record;
        $status->develop_status  = 10;
        $status->save();

        $status2 = Order_tag::where('tag_id',$request->tag_id)->first();
        $day = carbon::parse ($status2->end_time)->diffInDays($status2->estimated_time, false); //逾期日
        if($day >= 0){ //判斷逾期日
            $expected = 14;
        }else{
            $expected = 15;
        }

        $status2->day = $day;
        $status2->expected = $expected;
        $status2->save();
        
        $count = Order_tag::where('order_id',$status2->order_id)->whereNotIn('develop_status',[10])->count();
        if($count == 0){
            $order = Order::where('order_id',$status2->order_id)->first();
            $order->develop_status = 10;
            $order->save();
        }

        return parent::jsonResponse([
            'success' =>  'true'
        ]);
    }

}
