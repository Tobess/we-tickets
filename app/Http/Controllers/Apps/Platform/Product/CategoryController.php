<?php

namespace App\Http\Controllers\Apps\Platform\Product;

use App\Support\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 类目管理
 *
 * @package App\Http\Controllers\Apps\Platform
 */
class CategoryController extends Controller
{
    use JsonResponse;

    /**
     * 获得类目列表
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $query = \request('query');
        $pid = \request('pid') ?: 0;
        $dQue = \DB::table('bas_category')->where('id', '>', 0);
        if ($query) {
            $dQue->where(function ($sub) use ($query) {
                $sub->where('name', 'like', "{$query}%");
            });
        }
        if ($pid > 0) {
            $dQue->where('pid', $pid);
        }
        $rows = $dQue->paginate();
        $tops = \DB::table('bas_category')->where('pid', 0)->get(['id', 'name']);
        return view('apps.platform.product.category.list')
            ->with('rows', $rows)
            ->with('tops', $tops)
            ->with('query', $query)
            ->with('pid', $pid);
    }

    /**
     * 保存类目
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postStore(Request $request)
    {
        $id = $request->input('id', 0);
        $name = $request->input('name');
        $pid = $request->input('pid') ?: 0;

        if (!$name) {
            $msg = '类目名称不能为空！';
        } else {
            if ($id > 0) {
                $state = \DB::table('bas_category')->where('id', $id)->update(['name' => $name]);
            } else {
                $state = \DB::table('bas_category')->insert(['name' => $name, 'pid' => $pid]);
            }
            if ($state) {
                return self::retSuc();
            }
        }

        return self::retErr($msg ?? '类目保存失败！');
    }

    /**
     * 获得类目信息
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfile($id)
    {
        $cate = \DB::table('bas_category')->where('id', $id)->first();
        if (isset($cate->pid) && $cate->pid > 0) {
            $cate->pName = \DB::table('bas_category')->where('id', $cate->pid)->value('name');
        }

        return self::retDat($cate);
    }

    /**
     * 删除类目
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDestroy($id)
    {
        $cate = \DB::table('bas_category')->where('id', $id)->first();
        if ($cate) {
            if (\DB::table('bas_category')->where('pid', $id)->count() > 0 ||
                \DB::table('inv_product')->where('category_id', $id)->count() > 0) {
                $msg = '类目正在被使用禁止删除！';
            } else {
                \DB::table('bas_category')->where('id', $id)->delete();
                return back();
            }
        } else {
            $msg = '类目不存在！';
        }
        return back()->withErrors($msg ?? '删除类目失败！');
    }
}
