<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    /**
     * 跟模型相關聯的資料表。
     *
     * @var string
     */
    protected $table = 'order_personnel';

    /**
     * 跟資料表相關聯的主鍵。
     *
     * @var string
     */
    protected $primaryKey = 'pid';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 可大量指定的屬性。
     *
     * @var array
     */
    protected $fillable = [
        'tag_id',
        'leader',
        'name',
        'difficulty',
    ];

    // /**
    //  * 將屬性轉型為對應強型別。
    //  *
    //  * @var array
    //  */
    // protected $casts = [
    //     'difficulty'        => 'int',
    // ];
}
