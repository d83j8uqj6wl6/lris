<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
        /**
     * 跟模型相關聯的資料表。
     *
     * @var string
     */
    protected $table = 'option';

    /**
     * 跟資料表相關聯的主鍵。
     *
     * @var string
     */
    protected $primaryKey = 'option_id';

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
        'option_name',
        'option_value',
    ];

    /**
     * 轉為陣列時隱藏的欄位。
     *
     * @var array
     */
    protected $hidden = ['option_id','option_value','option_name'];

    /**
     * 要附加到模型陣列形式的存取子。
     *
     * @var array
     */
    protected $appends = ['value', 'text'];

    /**
     * 取得下拉選單選取值。
     *
     * @return string
     */
    public function getValueAttribute()
    {
        return $this->option_id;
    }

    /**
     * 取得下拉選單文字。
     *
     * @return string
     */
    public function getTextAttribute()
    {
        return $this->option_value;
    }
}
