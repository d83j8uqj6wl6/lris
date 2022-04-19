<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Option;
use App\Model\Company;
use App\Model\CompanyOpt;
use App\Model\User;
use Illuminate\Support\Arr;

class DataController extends Controller
{
    // public function getCustomerOpt123()
    // {
    //     return parent::jsonResponse([
    //         'options' =>
    //             Option::where('option_name','customer')->get()
    //     ]);
    // }
    
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

    // public function getMaterialOpt()
    // {
    //     return parent::jsonResponse([
    //         'options' =>
    //             Option::where('option_name','material')->get()
    //     ]);
    // }

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
    





    public function getCustomerOpt()
    {
        return parent::jsonResponse([
            'options' =>
            CompanyOpt::where('type',16)->where('state',0)->get()
        ]);
    }
    
    public function getCustomerFilter()
    {
        return parent::jsonResponse([
            'options' =>
            CompanyOpt::where('type',16)->get()
        ]);
    }


    public function getCompanyOpt()
    {
        return parent::jsonResponse([
            'options' =>
            CompanyOpt::where('type',17)->where('state',0)->get()
        ]);
    }

    public function getCompanyFilter()
    {
        return parent::jsonResponse([
            'options' =>
            CompanyOpt::where('type',17)->get()
        ]);
    }


    public function getMaterialOpt()
    {
        return parent::jsonResponse([
            'options' =>
            CompanyOpt::where('type',18)->where('state',0)->get()
        ]);
    }

    public function getMaterialFilter()
    {
        return parent::jsonResponse([
            'options' =>
            CompanyOpt::where('type',18)->get()
        ]);
    }


    public function getUserFilter()
    {
        return parent::jsonResponse([
            'options' =>
            User::select('id','name')->get()
        ]);
    }
}
