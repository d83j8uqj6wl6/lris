<?php

namespace App\Http\Controllers;

use App\Model\Order_tag;

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
}