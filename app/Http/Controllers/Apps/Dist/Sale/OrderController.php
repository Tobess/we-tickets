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
        $model = \request('model');
        if ($model) {
            $rows = \DB::table('orders')
                ->select('id', 'code', 'channel', 'client_mobile', 'client_name', 'client_identify',
                    'exchanged_at', 'charge_back_at')
                ->where('dist_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->paginate();
        } else {
            $rows = \DB::table('orders_items as oc')
                ->leftJoin('inv_product as p', 'oc.product_id', '=', 'p.id')
                ->leftJoin('inv_stock as s', 'oc.stock_id', '=', 's.id')
                ->leftJoin('orders as o', 'o.id', '=', 'oc.order_id')
                ->leftJoin('sc_distributor as d', 'o.dist_id', '=', 'd.id')
                ->select('o.id', 'o.code', 'o.channel', 'o.client_mobile', 'o.client_name', 'o.client_identify',
                    'o.exchanged_at', 'o.charge_back_at', 'd.name as d_name', 'p.name as p_name',
                    's.sku_note', 'oc.number', 'oc.price')
                ->where('o.dist_id', auth()->id())
                ->orderBy('o.created_at', 'desc')
                ->paginate();
        }

        return view('apps.distributor.order.list')
            ->with('rows', $rows)
            ->with('model', $model ?? 0);
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
            ->with('dists', $items);
    }


    /**
     * 添加订单商品
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate()
    {
        $rules = [
            'code' => 'required|string|unique:orders,code',
            'channel' => 'required|string',
            'client_mobile' => 'required',
            'client_name' => 'required',
            'client_identify' => 'required'
        ];
        $validator = validator(\request()->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        \DB::beginTransaction();
        $oid = \DB::table('orders')->insertGetId([
            'dist_id' => auth()->id(),
            'code' => \request('code'),
            'channel' => \request('channel'),
            'client_mobile' => \request('client_mobile'),
            'client_name' => \request('client_name'),
            'client_identify' => \request('client_identify'),
            'exchanged_at' => \request('exchanged_at') ?? now()
        ]);
        if ($oid > 0) {
            $items = \request('items');
            if (is_array($items) && count($items)) {
                foreach ($items as $did => $item) {
                    if ($did > 0 &&
                        isset($item['num']) && $item['num'] > 0) {
                        $dist = \DB::table('inv_stock_dist')
                            ->where('sd_id', $did)
                            ->where('sku_num', '>=', $item['num'])
                            ->where('dist_id', \Auth::id())
                            ->first(['product_id', 'stock_id', 'sd_id', 'dist_id']);
                        if ($dist) {
                            $state = \DB::table('orders_items')
                                    ->insert([
                                        'order_id' => $oid,
                                        'product_id' => $dist->product_id,
                                        'stock_id' => $dist->stock_id,
                                        'sd_id' => $dist->sd_id,
                                        'number' => $item['num'],
                                        'price' => $item['price'] ?? 0,
                                    ]) &&
                                \DB::table('inv_stock_dist')
                                    ->where('sd_id', $did)
                                    ->where('sku_num', '>=', $item['num'])
                                    ->where('dist_id', \Auth::id())
                                    ->update([
                                        'sku_num' => \DB::raw('sku_num-' . $item['num'])
                                    ]) > 0;
                            if (!$state) {
                                $msg = '商品[' . $item['title'] . ']添加到订单失败！';
                                break;
                            }
                        } else {
                            $msg = '商品[' . $item['title'] . ']不存在或库存不足！';
                        }
                    } else {
                        $msg = '订单商品中存在无效的记录！';
                    }
                }
            }

            if (!isset($state)) {
                $msg = $msg ?? '订单销售商品不能空！'.print_r($items, true);
            } else {
                if ($state) {
                    \DB::commit();
                    return back();
                }
            }
        }
        \DB::rollBack();


        return back()->withErrors($msg ?? '创建订单及明细失败！')->withInput();
    }

    /**
     * 删除订单
     *
     * @param int $id 订单ID
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getDestroy($id)
    {
        if (\DB::table('orders')
            ->where('id', $id)
            ->where('dist_id', \Auth::id())
            ->where('checked', false)
            ->exists()) {
            $items = \DB::table('orders_items')
                ->where('order_id', $id)
                ->select('product_id', 'stock_id', 'sd_id', 'number')
                ->get();
            \DB::beginTransaction();
            foreach ($items as $item) {
                $state = \DB::table('inv_stock_dist')
                        ->where('sd_id', $item->sd_id)
                        ->where('dist_id', \Auth::id())
                        ->update([
                            'sku_num' => \DB::raw('sku_num+' . $item->number)
                        ]) > 0;
                if (!$state) {
                    $msg = '恢复商品库存失败！';
                }
            }
            if (isset($state) && $state) {
                $state = \DB::table('orders_items')->where('order_id', $id)->delete() > 0 &&
                    \DB::table('orders')->where('id', $id)->delete() > 0;
                if ($state) {
                    \DB::commit();
                    return back();
                }
            }
        } else {
            $msg = '订单不存在或已经核销！';
        }

        return back()->withErrors($msg ?? '删除订单失败！');
    }
}
