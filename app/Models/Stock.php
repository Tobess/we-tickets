<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'inv_stock';

    public $timestamps = false;

    protected $fillable = [
        'id', 'product_id', 'sku_note', 'sku_code', 'sku_num',
        'sku_price', 'sku_cost', 'sku_key'
    ];
}
