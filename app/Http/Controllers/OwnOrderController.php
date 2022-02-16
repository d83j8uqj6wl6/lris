<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function getOwnOrderItem(Request $request)
    {
        $data = Order_tag::where('develop_id',4)->whereNotIn('develop_status',[10])->select('tag_id','order_id','develop_status','estimated_time')->with(["main" => function($q){
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

    public function savePersonnel(Request $request)
    {
        Personnel::create([
            'tag_id'        => $request->tag_id,
            'leader'        => $request->leader,
            'name'          => $request->name,
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
        $user = Auth::user();

        Material::create([
            'tag_id'        => $request->tag_id,
            'material_id'   => $request->material_id,
            'length'        => $request->length,
            'width'         => $request->width,
            'high'          => $request->high,
            'material'      => $request->material,
            'unit_price'    => $request->unit_price,
            'quantity'      => $request->quantity,
            'user_id'       => $user->id,
        ]);

        $data = Personnel::where('tag_id',$request->tag_id)->first();
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
    }
}
