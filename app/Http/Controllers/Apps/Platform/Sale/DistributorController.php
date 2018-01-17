<?php

namespace App\Http\Controllers\Apps\Platform\Sale;

use App\Models\Distributor;
use App\Models\Product;
use App\Models\Stock;
use App\Support\JsonResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 分销商管理
 *
 * @package App\Http\Controllers\Apps\Platform
 */
class DistributorController extends Controller
{
    /**
     * 获得分销商家列表
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        $rows =  Distributor::withTrashed()->orderBy('created_at', 'desc')->paginate();

        return view('apps.platform.sale.dist.list')
            ->with('rows', $rows);
    }

    /**
     * 编辑分销商资料
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function getEdit($id)
    {
        $row = Distributor::withTrashed()->find($id);

        return view('apps.platform.sale.dist.edit')
            ->with('row', $row);
    }

    /**
     * 保存分销商资料
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postStore()
    {
        $id = \request('id');
        $name = \request('name');
        $mobile = \request('mobile');
        $password = \request('password');
        if (!($name && $mobile)) {
            return back()->withErrors('分销商名称、电话不能为空！');
        }

        if ($id > 0 && !\DB::table('sc_distributor')->where('id', $id)->exists()) {
            return back()->withErrors('您指定要修改的分销商不存在！');
        }

        if (\DB::table('sc_distributor')
            ->where('mobile', $mobile)
            ->where('id', '<>', $id)
            ->exists()) {
            return back()->withErrors('手机号已经被他人使用！');
        }

        $values = [
            'name' => $name,
            'mobile' => $mobile,
            'deleted_at' => null
        ];
        if ($password) $values['password'] = bcrypt($password);
        $values['updated_at'] = Carbon::now();

        if ($id > 0) {
            $state = \DB::table('sc_distributor')
                    ->where('id', $id)
                    ->update($values) > 0;
        } else {
            $values['created_at'] = Carbon::now();
            $state = \DB::table('sc_distributor')->insert($values);
        }
        if ($state) {
            return redirect()->to(app_route('sale/distributor'));
        }

        return back()->withErrors('保存分销商资料失败！');
    }

    /**
     * 禁用分销商
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function getStop($id)
    {
        $row = Distributor::find($id);
        if ($row) {
            if ($row->delete()) {
                return back();
            }
        } else {
            $msg = '分销商不存在或已被禁用！';
        }

        return back()->withErrors($msg ?? '删除失败！');
    }

    // ----------------分销商品----------------

    /**
     * 获得分销商品详情
     * @return \Illuminate\View\View
     */
    public function getDistProducts()
    {
        $rows = \DB::table('inv_stock_dist as sd')
            ->leftJoin('inv_product as p', 'sd.product_id', '=', 'p.id')
            ->leftJoin('inv_stock as s', 'sd.stock_id', '=', 's.id')
            ->leftJoin('sc_distributor as d', 'd.id', '=', 'sd.dist_id')
            ->select('sd.sd_id as id', 'p.name as p_name', 's.sku_note', 'd.name as d_name',
                'sd.dist_total', 'sd.sku_price', 'sd.sku_num')
            ->orderBy('sd.created_at', 'desc')
            ->paginate();

        $dists = Distributor::select('id', 'name', 'mobile')->orderBy('created_at', 'desc')->get();
        $items = Product::select('id', 'name', 'item_no', 'price', 'quantity')
            ->where('quantity', '>', 0)
            ->orderBy('created_at', 'desc')->get();

        return view('apps.platform.sale.dist.item.list')
        ->with('rows', $rows)
        ->with('dists', $dists)
        ->with('items', $items);
    }

    /**
     * 添加分销商品
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDistProduct()
    {
        $distId = \request('dist_id');
        $productId = \request('product_id');
        $stockId = \request('stock_id');
        $number = intval(\request('sku_num'));
        $price = floatval(\request('sku_price'));

        if ($distId > 0 && $productId > 0 && $number > 0 && $price >= 0) {
            $dist = Distributor::find($distId);
            if ($dist) {
                $item = Product::find($productId);
                if ($item) {
                    if ($item->quantity > 0) {
                        \DB::beginTransaction();
                        if ($item->stocks()->count() > 0) {
                            if ($stockId > 0) {
                                $stock = Stock::find($stockId);
                                if ($stock && $stock->sku_num >= $number) {
                                    if (\DB::table('inv_stock_dist')
                                            ->where('dist_id', $distId)
                                            ->where('product_id', $productId)
                                            ->where('stock_id', 0)->count() > 0) {
                                        $msg = '该商品存在不按库存分销过，本次无法分销！';
                                    } else {
                                        $sdValues = [
                                            'dist_id' => $distId,
                                            'product_id' => $productId,
                                            'stock_id' => $stockId,
                                            'sku_num' => $number,
                                            'sku_price' => $price,
                                        ];
                                        if (\DB::table('inv_stock_dist')
                                                ->where('dist_id', $distId)
                                                ->where('product_id', $productId)
                                                ->where('stock_id', $stockId)->count() > 0) {
                                            $sdValues['updated_at'] = now();
                                            $sdValues['dist_total'] = \DB::raw('dist_total+' . $number);
                                            $sdValues['number'] = \DB::raw('number+' . $number);
                                            $sdValues['price'] = \DB::raw('price+' . $price);
                                            $state = \DB::table('inv_stock_dist')
                                                    ->where('dist_id', $distId)
                                                    ->where('product_id', $productId)
                                                    ->where('stock_id', $stockId)->update($sdValues) > 0;
                                        } else {
                                            $sdValues['created_at'] = now();
                                            $sdValues['updated_at'] = now();
                                            $sdValues['dist_total'] = $number;
                                            $state = \DB::table('inv_stock_dist')->insert($sdValues);
                                        }
                                        if ($state) {
                                            $state = \DB::table('inv_stock')
                                                ->where('id', $stockId)
                                                ->update([
                                                    'sku_num' => \DB::raw('sku_num-' . $number)
                                                ]) > 0 &&
                                                \DB::table('inv_product')
                                                    ->where('id', $productId)
                                                    ->update([
                                                        'quantity' => \DB::raw('quantity-' . $number),
                                                        'updated_at' => Carbon::now()
                                                    ]) > 0;
                                        }
                                    }
                                } else {
                                    $msg = '无效的库存！';
                                }
                            } else {
                                $msg = '无效的分销库存！';
                            }
                        } else {
                            if ($item->quantity >= $number) {
                                $sdValues = [
                                    'dist_id' => $distId,
                                    'product_id' => $productId,
                                    'stock_id' => 0,
                                    'sku_num' => $number,
                                    'sku_price' => $price,
                                ];
                                if (\DB::table('inv_stock_dist')
                                    ->where('dist_id', $distId)
                                    ->where('product_id', $productId)
                                    ->where('stock_id', 0)->count() > 0) {
                                    $sdValues['updated_at'] = now();
                                    $sdValues['number'] = \DB::raw('number+' . $number);
                                    $sdValues['price'] = \DB::raw('price+' . $price);
                                    $sdValues['dist_total'] = \DB::raw('dist_total+' . $number);
                                    $state = \DB::table('inv_stock_dist')
                                        ->where('dist_id', $distId)
                                        ->where('product_id', $productId)
                                        ->where('stock_id', 0)->update($sdValues) > 0;
                                } else {
                                    $sdValues['created_at'] = now();
                                    $sdValues['updated_at'] = now();
                                    $sdValues['dist_total'] = $number;
                                    $state = \DB::table('inv_stock_dist')->insert($sdValues);
                                }
                                if ($state) {
                                    $state = \DB::table('inv_product')
                                        ->where('id', $productId)
                                        ->update([
                                            'quantity' => \DB::raw('quantity-' . $number),
                                            'updated_at' => Carbon::now()
                                        ]) > 0;
                                }
                            } else {
                                $msg = '分销数量大于库存数！';
                            }
                        }
                        isset($state) && $state ? \DB::commit() : \DB::rollBack();
                    } else {
                        $msg = '分销商品无库存!';
                    }
                } else {
                    $msg = '无效的分销商品！';
                }
            } else {
                $msg = '无效的分销商！';
            }

        } else {
            $msg = '分销数据有误！';
        }

        return JsonResponse::response($state ?? false, $msg ?? '分销失败!');
    }

    /**
     * 取消分销
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDistProduct($id)
    {
        $sd = \DB::table('inv_stock_dist')->where('sd_id', $id)->first();
        if ($sd) {
            \DB::beginTransaction();
            $state = true;
            if ($sd->stock_id > 0) {
                $state = \DB::table('inv_stock')
                        ->where('id', $sd->stock_id)
                        ->update([
                            'sku_num' => \DB::raw('sku_num+' . $sd->sku_num),
                        ]) > 0;
            }
            if ($state &&
                \DB::table('inv_product')
                    ->where('id', $sd->prodcut_id)
                    ->update([
                        'quantity' => \DB::raw('quantity+' . $sd->sku_num),
                        'updated_at' => Carbon::now()
                    ]) > 0 &&
                \DB::table('inv_stock_dist')->where('sd_id', $id)->delete() > 0) {
                \DB::commit();
                return back();
            }
            \DB::rollBack();
        } else {
            $msg = '无效的分销！';
        }

        return back()->with($msg ?? '取消分销失败！');
    }
}
