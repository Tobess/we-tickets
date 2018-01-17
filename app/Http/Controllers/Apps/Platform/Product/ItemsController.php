<?php

namespace App\Http\Controllers\Apps\Platform\Product;

use App\Models\Product;
use App\Models\SKU;
use App\Models\Stock;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemsController extends Controller
{
    use JsonResponse;

    /**
     * 获得产品列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $query = \request('query');
        $iQue = \DB::table('inv_product');
        if ($query) {
            $iQue->where('name', 'like', "%{$query}%");
        }

        $rows = $iQue
            ->orderBy('created_at', 'desc')
            ->paginate();

        return app_view('product.items.list')
            ->with('rows', $rows);
    }

    /**
     * 编辑商品详情
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function getEdit($id = 0)
    {
        if ($id) {
            $item = Product::find($id);
            if (!$item && $id > 0) {
                return redirect()->to(app_route('product/items'))->withErrors('商品不存在');
            }
        }

        if ($item && $item->id > 0) {
            $stocksArr = \DB::table('inv_stock')
                ->where('product_id', $item->id)
                ->select('sku_note as title', 'sku_key as k', 'sku_code as code',
                    'sku_num as stock_num', 'sku_price as price', 'sku_cost as cost_price', 'sku_eles as cols')
                ->get();
            $stocks = [];
            $skus = [];
            foreach ($stocksArr as $stock) {
                $stock->cols = json_decode($stock->cols);
                if (is_array($stock->cols)) {
                    foreach ($stock->cols as $col) {
                        if (!isset($skus[$col->t])) $skus[$col->t] = [];
                        if (!in_array($col->v, $skus[$col->t])) $skus[$col->t][] = $col->v;
                    }
                }
                $stocks[] = $stock;
            }
        }

        $cateArr = \DB::table('bas_category as bc')
            ->where('bc.id', '>', 0)
            ->select('bc.id', 'bc.name', 'bc.pid',
                \DB::raw("(select name from bas_category where id=bc.pid) as pName"))
            ->where('pid', '>', 0)
            ->get();
        foreach ($cateArr as $cate) {
            if (!isset($categories[$cate->pid])) {
                $categories[$cate->pid] = [
                    'id' => $cate->pid,
                    'name' => $cate->pName
                ];
            }
            if (isset($item->category_id) && $cate->id == $item->category_id) {
                $cate->selected = true;
            }
            $categories[$cate->pid]['children'][$cate->id] = $cate;
        }

        return app_view('product.items.edit')
            ->with('goods', $item)
            ->with('stocks', $stocks ?? [])
            ->with('skus', $skus ?? [])
            ->with('categories', array_values($categories));
    }

    /**
     * 保存产品资料
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postStore(Request $request)
    {
        $id = intval($request->input('id', 0));
        $rules = [
            'name' => 'required|string',
            'venue_id' => 'exists:bas_venue,id',
            'category_id' => 'exists:bas_category,id'
        ];

        $validator = validator($request->input(), $rules);
        if ($validator->fails()) {
            return self::retErr($validator->errors()->first());
        }

//        if (!\DB::table('bas_venue_category')
//            ->where('venue_id', $request->input('venue_id'))
//            ->where('category_id', $request->input('category_id'))
//            ->exists()) {
//            return self::retErr('您选择的场馆的经营类目不包含您选择的类目！');
//        }

        if ($id > 0 && !Product::where('id', $id)->exists()) {
            return self::retErr('您要保存的商品不存在！');
        }

        $state = false;
        \DB::beginTransaction();
        $product = $id > 0 ? Product::firstOrNew(['id' => $id], $request->input()) : new Product($request->input());
        $richText = $request->get('richtext');
        if ($richText) {
            $product->richtext = $richText;
        }
        if ($product->save()) {
            $state = true;
            // Stock
            $stocks = $request->get('stocks');
            if (is_array($stocks) && count($stocks) > 0) {
                Stock::where('product_id', $product->id)->delete();
                foreach ($stocks as $item) {
                    $stock = new Stock();
                    $stock->sku_note = $item['title'];
                    $stock->sku_key = $item['k'];
                    if (isset($item['code']) && $item['code']) {
                        $stock->sku_code = $item['code'];
                    }
                    $stock->sku_num = intval($item['stock_num'] ?? 0);
                    $stock->sku_price = floatval($item['price'] ?? 0);
                    $stock->sku_cost = floatval($item['cost_price'] ?? 0);
                    $stock->sku_eles = json_encode($item['cols']);
                    $stock->product_id = $product->id;
                    if ($stock->save()) {
                        continue;
                    }

                    $state = false;
                    $msg = '产品SKU保存失败！';
                    break;
                }
            }
        }
        if ($state) {
            \DB::commit();
            return self::retSuc($product->id);
        }
        \DB::rollBack();

        return self::retErr($msg ?? '保存产品资料失败!');
    }

    /**
     * 删除产品
     *
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        $item = Product::find($id);
        if ($item) {
            \DB::beginTransaction();
            $state = $item->delete() > 0 && Stock::where('product_id', $id)->delete() >= 0;
            $state ? \DB::commit() : \DB::rollBack();
            return back();
        } else {
            $msg = '产品不存在或产品正在被使用！';
        }
        return back()->withErrors($msg ?? '删除产品失败！');
    }

    /**
     * 获得产品库存信息
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductStocks($id)
    {
        /**
         * @var Product $item
         */
        $item = Product::find($id);
        if ($item) {
            $stocks = $item->stocks()
                ->select('id', 'sku_note as title', 'sku_code as code', 'sku_num as num', 'sku_price as price')
                ->get();

        }

        return self::retDat($stocks ?? []);
    }
}
