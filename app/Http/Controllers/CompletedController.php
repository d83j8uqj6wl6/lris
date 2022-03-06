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
    public function getCompletedItem(Request $request)
    {
        $data = Order_tag::where('develop_status',10)->select('tag_id','order_id','develop_id','develop_status','estimated_time','end_time','expected','day')->with(["main" => function($q){
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
