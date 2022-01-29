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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(['prefix' => 'auth'],
//     function ($router) {
//         Route::post('/login', 'AuthController@login'); //登入
//         Route::get('/logout', 'AuthController@logout'); //登出
//         Route::get('/refresh', 'AuthController@refresh'); //更新token
//         Route::get('/me', 'AuthController@me'); //顯示個人資料
//     }
// );
Route::prefix('auth')->group(function () {
    Route::post('/login', 'AuthController@login'); //登入
    Route::get('/logout', 'AuthController@logout'); //登出
    Route::get('/refresh', 'AuthController@refresh'); //更新token
    Route::get('/me', 'AuthController@me'); //顯示個人資料
});


Route::post('/addOrder', 'OrderController@addOrder'); //新增訂單
Route::post('/getOrderItem', 'OrderController@getOrderItem'); //顯示訂單列表
Route::post('/getOrderData', 'OrderController@getOrderData'); //顯示編輯訂單資料




