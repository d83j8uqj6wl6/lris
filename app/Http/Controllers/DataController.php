<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Option;
use App\Model\Company;
use App\Model\User;
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

    public function getMaterialOpt()
    {
        return parent::jsonResponse([
            'options' =>
                Option::where('option_name','material')->get()
        ]);
    }

    public function getExpectedOpt()
    {
        return parent::jsonResponse([
            'options' =>
                Option::where('option_name','overdue')->get()
        ]);
    }

    public function getTypeOpt()
    {
        return parent::jsonResponse([
            'options' =>
                Option::where('option_name','type')->get()
        ]);
    }
    
    public function company()
    {
        return parent::jsonResponse([
            'options' =>
            Company::where('type',18)->get()
        ]);
    }

    public function getUserOpt()
    {
        return parent::jsonResponse([
            'options' =>
            User::select('id','name')->get()
        ]);
    }
}
