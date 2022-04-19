<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', 'AuthController@login'); //登入
    Route::get('/logout', 'AuthController@logout'); //登出
    Route::get('/refresh', 'AuthController@refresh'); //更新token
    Route::get('/me', 'AuthController@me'); //顯示個人資料
    Route::post('/register', 'AuthController@register'); //註冊帳號
    Route::post('/resetpassword', 'AuthController@resetpassword'); //修改密碼
});

Route::get('/getCustomerFilter'   , 'DataController@getCustomerFilter'); //客戶代碼轉換 OK
Route::get('/getCustomerOpt'      , 'DataController@getCustomerOpt');    //客戶下拉 OK
Route::get('/getCompanyOpt'       , 'DataController@getCompanyOpt');     //廠商下拉OK
Route::get('/getCompanyFilter'    , 'DataController@getCompanyFilter');  //廠商代碼轉換OK
Route::get('/getMaterialOpt'      , 'DataController@getMaterialOpt');    //材質狀態下拉OK
Route::get('/getMaterialFilter'   , 'DataController@getMaterialFilter'); //材質狀態代碼轉換OK
Route::get('/getUserFilter'          , 'DataController@getUserFilter');              //使用者下拉V

Route::get('/getDevelopOpt'       , 'DataController@getDevelopOpt');        //開發模式下拉OK
Route::get('/getDevelopStatusOpt' , 'DataController@getDevelopStatusOpt');  //開發狀態下拉V
Route::get('/getExpectedOpt'      , 'DataController@getExpectedOpt');       //逾期狀態下拉V
Route::get('/getTypeOpt'          , 'DataController@getTypeOpt');              //型態下拉V

Route::post('/addorder'           , 'OrderController@addOrder');          //新增訂單 OK
Route::post('/getOrderItem'       , 'OrderController@getOrderItem');      //顯示訂單列表 OK
Route::post('/getOrderData'       , 'OrderController@getOrderData');      //顯示編輯訂單資料 OK
Route::post('/saveOrderData'      , 'OrderController@saveOrderData');     //儲存修改的訂單 OK
Route::post('/delOrderData'       , 'OrderController@delOrderData');      //刪除訂單  OK
Route::post('/setMode'            , 'OrderController@setMode');           //設定開發模式 OK
Route::post('/createMaterial'     , 'OrderController@createMaterial');    //新增材料 OK       
Route::post('/getMaterial'        , 'OrderController@getMaterial');       //取得材料資訊 OK    
Route::post('/saveMaterialData'   , 'OrderController@saveMaterialData');  //儲存修改的材料 OK     


Route::post('/getOwnOrderItem'  , 'OwnOrderController@getOwnOrderItem'); //顯示自家開發訂單列表 OK
Route::post('/savepersonnel'    , 'OwnOrderController@savePersonnel');   //設定自家管理人員輸入 OK
Route::post('/setOwnFinish'     , 'OwnOrderController@setOwnFinish');    //設定自家管理發開完成 OK
Route::post('/confirm'          , 'OwnOrderController@confirm');         //設定自家管理主管確認 OK


Route::post('/getOutsourceOrderItem'    , 'OutsourceOrderController@getOutsourceOrderItem'); //顯示委外開發訂單列表 OK
Route::post('/saveOutsourcePersonnel'   , 'OutsourceOrderController@saveOutsourcePersonnel'); //設定委外開發廠商輸入 OK
Route::post('/setOutsourceFinish'       , 'OutsourceOrderController@setOutsourceFinish'); //設定委外開發完成 OK

Route::post('/getCompletedItem' , 'CompletedController@getCompletedItem');  //完成訂單列表 OK
Route::post('/getDetail'        , 'CompletedController@getDetail');         //完成訂單細項OK

Route::post('/getOptList'        , 'OptController@getOptList');         //完成訂單細項
Route::post('/createType'        , 'OptController@createType');         //完成訂單細項
Route::post('/getTypeData'        , 'OptController@getTypeData');         //完成訂單細項
Route::post('/saveTypeData'        , 'OptController@saveTypeData');         //完成訂單細項
Route::post('/delTypeData'        , 'OptController@delTypeData');         //完成訂單細項
