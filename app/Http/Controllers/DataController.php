<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Option;
use Illuminate\Support\Arr;

class DataController extends Controller
{
    public function getCustomerOpt()
    {
        return parent::jsonResponse([
            'options' =>
                Arr::prepend(Option::where('option_name','customer')->get([ 'option_id', 'option_value'])->toArray(), [
                    'value' => null,
                    'text' => '請選擇',
                ])
        ]);
    }
}
