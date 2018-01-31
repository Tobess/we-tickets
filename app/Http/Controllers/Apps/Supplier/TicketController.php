<?php

namespace App\Http\Controllers\Apps\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    /**
     * 根据客户手机号查询已购票
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getCheck()
    {
        $query = \request('query');
        $user = auth('supplier')->user();
        \Log::info(print_r($user, true));
        if ($user && $query) {
            $tickets = \DB::table('orders_items as oi')
                ->leftJoin('inv_product as ip', 'oi.product_id', '=', 'ip.id')
                ->leftJoin('inv_stock as is', 'oi.stock_id', '=', 'is.id')
                ->leftJoin('orders as o', 'o.id', '=', 'oi.order_id')
                ->where('o.checked', false)
                ->where('ip.venue_id', $user->venue_id)
                ->where('o.client_mobile', $query)
                ->select('o.id as order_id', 'o.code as order_code', 'o.client_mobile',
                    'o.client_name', 'o.client_identify', 'oi.product_id', 'oi.number',
                    'ip.name as product_name', 'is.sku_note')
                ->get();
            $ret = [];
            foreach ($tickets as $ticket) {
                if (!isset($ret[$ticket->order_id])) {
                    $ret[$ticket->order_id] = [
                        'order_id' => $ticket->order_id,
                        'order_code' => $ticket->order_code,
                        'client_mobile' => $ticket->client_mobile,
                        'client_name' => $ticket->client_name,
                        'client_identify' => $ticket->client_identify,
                        'total' => 0,
                        'items' => []
                    ];
                }
                $ret[$ticket->order_id]['total'] += $ticket->number;
                $ret[$ticket->order_id]['items'][] = [
                    'product_id' => $ticket->product_id,
                    'product_name' => $ticket->product_name,
                    'sku_note' => $ticket->sku_note,
                    'number' => $ticket->number,
                ];
            }
        }
        return response(isset($ret) ? array_values($ret) : []);
    }

    /**
     * 供应商出票
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function postPick()
    {
        $orders = \request('orders');
        $mobile = \request('mobile');
        $user = auth('supplier')->user();
        if ($user && $orders) {
            $orders = explode(',', $orders);
            $orders = \DB::table('orders_items as oi')
                ->leftJoin('inv_product as ip', 'oi.product_id', '=', 'ip.id')
                ->leftJoin('inv_stock as is', 'oi.stock_id', '=', 'is.id')
                ->leftJoin('orders as o', 'o.id', '=', 'oi.order_id')
                ->where('o.checked', false)
                ->where('ip.venue_id', $user->venue_id)
                ->where('o.client_mobile', $mobile)
                ->whereIn('o.id', $orders)
                ->pluck('o.id');
            if (!empty($orders)) {
                \DB::beginTransaction();
                if (\DB::table('orders')
                        ->where('checked', false)
                        ->whereIn('id', $orders)
                        ->update([
                            'checked' => true,
                            'checked_supplier' => $user->id,
                            'updated_at' => now()
                        ]) == count($orders)) {
                    \DB::commit();
                    return response(['state' => true, 'data' => $orders]);
                } else {
                    \DB::rollBack();
                }
            }
        }
        return response(['state' => false]);
    }

    /**
     * 获得已核过的票
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getPickedTickets()
    {
        $start = \request('d_start');
        $end = \request('d_end');

        $user = auth('supplier')->user();
        $que = \DB::table('orders_items as oi')
            ->leftJoin('inv_product as ip', 'oi.product_id', '=', 'ip.id')
            ->leftJoin('inv_stock as is', 'oi.stock_id', '=', 'is.id')
            ->leftJoin('orders as o', 'o.id', '=', 'oi.order_id')
            ->where('o.checked', true)
            ->where('ip.venue_id', $user->venue_id)
            ->where('o.checked_supplier', $user->id)
            ->select('o.id as order_id', 'o.code as order_code', 'o.client_mobile',
                'o.client_name', 'o.client_identify', 'oi.product_id', 'oi.number',
                'ip.name as product_name', 'is.sku_note');
        if ($start) {
            $que->where('o.updated_at', '>=', $start . '00:00:00');
        }
        if ($end) {
            $que->where('o.updated_at', '<=', $end . '23:59:59');
        }
        $tickets = $que->get();
        $ret = [];
        foreach ($tickets as $ticket) {
            if (!isset($ret[$ticket->order_id])) {
                $ret[$ticket->order_id] = [
                    'order_id' => $ticket->order_id,
                    'order_code' => $ticket->order_code,
                    'client_mobile' => $ticket->client_mobile,
                    'client_name' => $ticket->client_name,
                    'client_identify' => $ticket->client_identify,
                    'total' => 0,
                    'items' => []
                ];
            }
            $ret[$ticket->order_id]['total'] += $ticket->number;
            $ret[$ticket->order_id]['items'][] = [
                'product_id' => $ticket->product_id,
                'product_name' => $ticket->product_name,
                'sku_note' => $ticket->sku_note,
                'number' => $ticket->number,
            ];
        }

        return response(array_values($ret));
    }
}
