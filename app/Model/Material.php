<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    /**
     * 跟模型相關聯的資料表。
     *
     * @var string
     */
    protected $table = 'order_material';

    /**
     * 跟資料表相關聯的主鍵。
     *
     * @var string
     */
    protected $primaryKey = 'aluminum_id';

    /**
     * 可大量指定的屬性。
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'material_id',
        'length',
        'width',
        'high',
        'material',
        'unit_price',
        'quantity',
        'user_id',
        'created_at',
        'updated_at'
    ];

    /**
     * 將屬性轉型為對應強型別。
     *
     * @var array
     */
    protected $casts = [
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
    ];
}
