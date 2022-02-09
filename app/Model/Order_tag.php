<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order_tag extends Model
{
    /**
     * 跟模型相關聯的資料表。
     *
     * @var string
     */
    protected $table = 'order_tag';

    /**
     * 跟資料表相關聯的主鍵。
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * 可大量指定的屬性。
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'develop_id',
        'schedule',
        'expected',
        'day',
        'start_time',
        'end_time',
        'estimated_time',
        'created_at',
        'updated_at'
    ];

    /**
     * 將屬性轉型為對應強型別。
     *
     * @var array
     */
    protected $casts = [
        'start_time'        => 'datetime',
        'end_time'          => 'datetime',
        'estimated_time'    => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
    ];
}