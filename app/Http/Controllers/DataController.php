<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
    public function getCommercialDistricts()
    {
        return parent::jsonResponse([
            'options' =>
                Arr::prepend(CommercialDistrict::all()->toArray(), [
                    'value' => null,
                    'text' => '請選擇',
                ])
        ]);
    }
}
