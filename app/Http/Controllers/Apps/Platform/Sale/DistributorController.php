<?php

namespace App\Http\Controllers\Apps\Platform\Sale;

use App\Models\Distributor;
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
}
