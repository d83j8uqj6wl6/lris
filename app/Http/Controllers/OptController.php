<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Company;

class OptController extends Controller
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

    public function getOptList(Request $request)
    {
        if ($type = $request->input('type')){
            $storeinfoexport = Company::where('type',$type)->where('state',0);
        }else{
            $storeinfoexport = Company::where('state',0);
        }
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

    public function createType(Request $request)
    {
        Company::create([
            'name' => $request->name,
            'type' => $request->type
        ]);
        return parent::jsonResponse([
            'success' => true
        ]);
    }

    public function getTypeData(Request $request)
    {
        $data = Company::where('cid',$request->cid)->first();
        return parent::jsonResponse([
            'data' => $data
        ]);
    }

    public function saveTypeData(Request $request)
    {
        $data = Company::where('cid',$request->cid)->first();

        $data->name     = $request->name; 
        $data->save();

        return parent::jsonResponse([
            'success' =>  'true'
        ]);
    }

    public function delTypeData(Request $request)
    {
        $data = Company::where('cid',$request->cid)->first();

        $data->state     = 1; 
        $data->save();

        return parent::jsonResponse([
            'success' =>  'true'
        ]);
    }
}
