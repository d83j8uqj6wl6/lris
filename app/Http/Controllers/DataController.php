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
                Option::where('option_name','customer')->get()
        ]);
    }
    
    public function getDevelopOpt()
    {
        return parent::jsonResponse([
            'options' =>
                Option::where('option_name','develop')->get()
        ]);
    }

    public function getDevelopStatusOpt()
    {
        return parent::jsonResponse([
            'options' =>
                Option::where('option_name','develop_status')->get()
        ]);
    }
}
