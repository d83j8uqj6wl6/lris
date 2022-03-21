<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
        /**
     * 跟模型相關聯的資料表。
     *
     * @var string
     */
    protected $table = 'company';

    /**
     * 跟資料表相關聯的主鍵。
     *
     * @var string
     */
    protected $primaryKey = 'cid';

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
        'name',
    ];

}
