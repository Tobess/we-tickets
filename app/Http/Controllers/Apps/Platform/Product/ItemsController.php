<?php

namespace App\Http\Controllers\Apps\Platform\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemsController extends Controller
{
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

    public function getEdit($id)
    {
        $tops = \DB::table('bas_category')->where('pid', 0)->get(['id', 'name']);

        return app_view('product.items.edit')
            ->with('tops', $tops);
    }
}
