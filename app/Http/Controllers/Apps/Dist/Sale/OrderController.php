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
}
