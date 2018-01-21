<?php

namespace App\Http\Controllers\Apps\Platform\Sale;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * 获得销售订单列表
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        $model = \request('model');
        if ($model) {
            $rows = \DB::table('orders as o')
                ->leftJoin('sc_distributor as d', 'o.dist_id', '=', 'd.id')
                ->select('o.id', 'o.code', 'o.channel', 'o.client_mobile', 'o.client_name', 'o.client_identify',
                    'o.exchanged_at', 'o.charge_back_at', 'd.name as d_name')
                ->orderBy('o.created_at', 'desc')
                ->paginate();
        } else {
            $rows = \DB::table('orders_items as oc')
                ->leftJoin('inv_product as p', 'oc.product_id', '=', 'p.id')
                ->leftJoin('inv_stock as s', 'oc.stock_id', '=', 's.id')
                ->leftJoin('orders as o', 'o.id', '=', 'oc.order_id')
                ->leftJoin('sc_distributor as d', 'o.dist_id', '=', 'd.id')
                ->select('o.id', 'o.code', 'o.channel', 'o.client_mobile', 'o.client_name', 'o.client_identify',
                    'o.exchanged_at', 'o.charge_back_at', 'd.name as d_name', 'p.name as p_name', 's.sku_note', 'oc.number', 'oc.price')
                ->orderBy('o.created_at', 'desc')
                ->paginate();
        }

        return view('apps.platform.sale.order.list')
            ->with('rows', $rows)
            ->with('model', $model ?? 0);
    }
}
