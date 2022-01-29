<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * 跟模型相關聯的資料表。
     *
     * @var string
     */
    protected $table = 'order';

    /**
     * 跟資料表相關聯的主鍵。
     *
     * @var string
     */
    protected $primaryKey = 'order_id';

    /**
     * 可大量指定的屬性。
     *
     * @var array
     */
    protected $fillable = [
        'customer',
        'order_num',
        'order_date',
        'item_num',
        'item_name',
        'quantity',
        'pre_delivery_data',
        'reply_date',
        'develop_id',
        'develop_status',
        'user_id',
        'created_at',
        'updated_at',
    ];

    /**
     * 轉為陣列時隱藏的欄位。
     *
     * @var array
     */

    protected $hidden = [
        'user_id',
    ];

    /**
     * 將屬性轉型為對應強型別。
     *
     * @var array
     */
    protected $casts = [
        'develop_id'        => 'integer',
        'order_date'        => 'datetime',
        'pre_delivery_data' => 'datetime',
        'reply_date'        => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
    ];
    
    // public function areasOpt() {
    //     return $this->hasMany(Area::class, 'county_code', 'resident_city');
    // }
}
