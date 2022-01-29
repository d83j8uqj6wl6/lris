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
            'order_date'        => Carbon::now(),
            'item_num'          => $request->item_num,
            'item_name'         => $request->item_name,
            'quantity'          => $request->quantity,
            'pre_delivery_data' => Carbon::now(),
            'reply_date'        => Carbon::now(),
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
        $data = Order::query()->get();
        return parent::jsonResponse([
            $data
        ]);
    }
}
