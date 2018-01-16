<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'inv_product';

    protected $fillable = [
        'name','category_id','venue_id','desc','price','origin_price',
        'quantity','item_no','item_cost','star','item_type','star_time',
        'richtext'
    ];

    /**
     * 库存数据
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks()
    {
        return $this->hasMany('App\Models\Stock', 'product_id', 'id');
    }
}
