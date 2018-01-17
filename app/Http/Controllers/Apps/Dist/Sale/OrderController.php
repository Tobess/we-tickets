<?php

namespace App\Http\Controllers\Apps\Dist\Sale;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * 获得分销商的销售订单列表
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        \Log::info(print_r(auth()->user(), true));
        $rows = \DB::table('orders')
            ->select('id', 'code', 'channel', 'client_mobile', 'client_name', 'client_identify',
                'exchanged_at', 'charge_back_at')
            ->where('dist_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate();

        return view('apps.distributor.order.list')
            ->with('rows', $rows);
    }

    /**
     * 显示订单创建页面
     *
     * @return \Illuminate\View\View
     */
    public function getCreate()
    {
        $items = \DB::table('inv_stock_dist as sd')
            ->leftJoin('inv_product as p', 'sd.product_id', '=', 'p.id')
            ->leftJoin('inv_stock as s', 'sd.stock_id', '=', 's.id')
            ->leftJoin('sc_distributor as d', 'd.id', '=', 'sd.dist_id')
            ->select('sd.sd_id as id', 'p.name as p_name', 's.sku_note', 'd.name as d_name',
                'sd.dist_total', 'sd.sku_price', 'sd.sku_num')
            ->where('d.id', auth()->id())
            ->orderBy('sd.created_at', 'desc')
            ->get();

        return view('apps.distributor.order.edit')
            ->with('items', $items);
    }


    public function postCreate()
    {
        //
    }
}
