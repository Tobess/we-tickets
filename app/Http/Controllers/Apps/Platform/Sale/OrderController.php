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
        $rows = \DB::table('orders as o')
            ->leftJoin('sc_distributor as d', 'o.dist_id', '=', 'd.id')
            ->select('o.id', 'o.code', 'o.channel', 'o.client_mobile', 'o.client_name', 'o.client_identify',
                'o.exchanged_at', 'o.charge_back_at', 'd.name as d_name')
            ->orderBy('o.created_at', 'desc')
            ->paginate();

        return view('apps.platform.sale.order.list')
            ->with('rows', $rows);
    }
}
