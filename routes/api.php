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
});


Route::post('/addorder', 'OrderController@addOrder'); //新增訂單V
Route::post('/getOrderItem', 'OrderController@getOrderItem'); //顯示訂單列表V
Route::post('/getOrderData', 'OrderController@getOrderData'); //顯示編輯訂單資料V

Route::get('/getCustomerOpt', 'DataController@getCustomerOpt'); //客戶下拉V
Route::get('/getDevelopOpt', 'DataController@getDevelopOpt'); //開發模式下拉V
Route::get('/getDevelopStatusOpt', 'DataController@getDevelopStatusOpt'); //開發狀態下拉V
Route::get('/getMaterialOpt', 'DataController@getMaterialOpt'); //材質狀態下拉V
Route::get('/getExpectedOpt', 'DataController@getExpectedOpt'); //逾期狀態下拉V

Route::post('/saveOrderData', 'OrderController@saveOrderData'); //儲存修改的訂單V
Route::post('/delOrderData', 'OrderController@delOrderData'); //刪除訂單V
Route::post('/setMode', 'OrderController@setMode'); //設定開發模式V


Route::post('/getOwnOrderItem', 'OwnOrderController@getOwnOrderItem'); //顯示自家開發訂單列表V
Route::post('/savepersonnel', 'OwnOrderController@savePersonnel'); //設定自家管理人員輸入V
Route::post('/setOwnFinish', 'OwnOrderController@setOwnFinish'); //設定自家管理發開完成V
Route::post('/confirm', 'OwnOrderController@confirm'); //設定自家管理主管確認V

Route::post('/getOutsourceOrderItem', 'OutsourceOrderController@getOutsourceOrderItem'); //顯示委外開發訂單列表V
Route::post('/saveOutsourcePersonnel', 'OutsourceOrderController@saveOutsourcePersonnel'); //設定委外開發廠商輸入V
Route::post('/setOutsourceFinish', 'OutsourceOrderController@setOutsourceFinish'); //設定委外開發完成V

Route::post('/getCompletedItem', 'CompletedController@getCompletedItem'); //顯示委外開發訂單列表V
Route::post('/password', 'CompletedController@password'); //顯示委外開發訂單列表V
