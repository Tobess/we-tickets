<?php

namespace App\Http\Controllers\Apps\Platform\Product;

use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    /**
     * 获得供应商列表
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        $rows = \DB::table('sc_supplier as s')
            ->leftJoin('bas_venue as v', 's.venue_id', '=', 'v.id')
            ->select('s.id', 's.name', 's.mobile', 's.updated_at', 's.created_at',
                'venue_id', 'v.name as venue_name', 'deleted_at')
            ->orderBy('s.created_at', 'desc')
            ->paginate();
        return view('apps.platform.product.supplier.list')
            ->with('rows', $rows);
    }

    /**
     * 编辑供应商资料
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function getEdit($id)
    {
        $row = \DB::table('sc_supplier as s')
            ->leftJoin('bas_venue as v', 's.venue_id', '=', 'v.id')
            ->where('s.id', $id)
            ->select('s.id', 's.name', 's.mobile', 's.updated_at', 's.created_at',
                'venue_id', 'v.name as venue_name', 'deleted_at')
            ->first();

        $venues = \DB::table('bas_venue_category as vc')
            ->leftJoin('bas_venue as v', 'v.id', '=', 'vc.venue_id')
            ->where('vc.category_id', '>', 0)
            ->get(['v.id', 'v.name']);

        return view('apps.platform.product.supplier.edit')
            ->with('row', $row)
            ->with('venues', $venues);
    }

    /**
     * 保存供应商资料
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postStore()
    {
        $id = \request('id');
        $name = \request('name');
        $mobile = \request('mobile');
        $password = \request('password');
        $venue = \request('venue_id');
        if (!($name && $mobile && $venue > 0)) {
            return back()->withErrors('供应商名称、电话、场馆不能为空！');
        }

        if ($id > 0 && !\DB::table('sc_supplier')->where('id', $id)->exists()) {
            return back()->withErrors('您指定要修改的供应商不存在！');
        }

        if (\DB::table('sc_supplier')
            ->where('mobile', $mobile)
            ->where('id', '<>', $id)
            ->exists()) {
            return back()->withErrors('手机号已经被他人使用！');
        }

        $values = [
            'name' => $name,
            'mobile' => $mobile,
            'venue_id' => $venue,
            'deleted_at' => null
        ];
        if ($password) $values['password'] = bcrypt($password);
        $values['updated_at'] = Carbon::now();

        if ($id > 0) {
            $state = \DB::table('sc_supplier')
                    ->where('id', $id)
                    ->update($values) > 0;
        } else {
            $values['created_at'] = Carbon::now();
            $state = \DB::table('sc_supplier')->insert($values);
        }
        if ($state) {
            return redirect()->to(app_route('product/supplier'));
        }

        return back()->withErrors('保存供应商资料失败！');
    }

    /**
     * 禁用供应商
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStop($id)
    {
        $row = Supplier::find($id);
        if ($row) {
            if ($row->delete()) {
                return back();
            }
        } else {
            $msg = '商户不存在或已被禁用！';
        }

        return back()->withErrors($msg ?? '删除失败！');
    }
}
