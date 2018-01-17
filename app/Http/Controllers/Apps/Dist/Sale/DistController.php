<?php

namespace App\Http\Controllers\Apps\Dist\Sale;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DistController extends Controller
{
    /**
     * 获得分销商的分销商品详情
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        $rows = \DB::table('inv_stock_dist as sd')
            ->leftJoin('inv_product as p', 'sd.product_id', '=', 'p.id')
            ->leftJoin('inv_stock as s', 'sd.stock_id', '=', 's.id')
            ->leftJoin('sc_distributor as d', 'd.id', '=', 'sd.dist_id')
            ->select('sd.sd_id as id', 'p.name as p_name', 's.sku_note', 'd.name as d_name',
                'sd.dist_total', 'sd.sku_price', 'sd.sku_num')
            ->where('d.id', auth()->id())
            ->orderBy('sd.created_at', 'desc')
            ->paginate();

        return view('apps.distributor.item.list')
            ->with('rows', $rows);
    }
}
