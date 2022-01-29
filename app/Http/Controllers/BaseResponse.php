<?php

namespace App\Http\Controllers;

trait BaseResponse
{
    /**
     * 回傳 Json 結構，採用 UTF-8 編碼，不對 Unicode 字元做跳脫序列編碼。
     *
     * @param  mixed  $data
     * @param  int    $status
     * @param  array  $headers
     * @param  int    $options
     * @return \Illuminate\Contracts\Support\Jsonable
     */
    protected function jsonResponse($data = null, $status = 200, $headers = [], $options = 0)
    {
        return response()
            ->json($data, $status, $headers, JSON_UNESCAPED_UNICODE | $options)
            ->header('Content-Type', 'application/json; charset=utf-8');
    }
}
