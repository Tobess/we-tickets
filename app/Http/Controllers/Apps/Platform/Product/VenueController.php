<?php

namespace App\Http\Controllers\Apps\Platform\Product;

use App\Support\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 场馆管理
 *
 * @package App\Http\Controllers\Apps\Platform
 */
class VenueController extends Controller
{
    use JsonResponse;

    /**
     * 获得场馆列表
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $query = \request('query');
        $dQue = \DB::table('bas_venue')->where('id', '>', 0);
        if ($query) {
            $dQue->where(function ($sub) use ($query) {
                $sub->where('name', 'like', "{$query}%");
            });
        }
        $venues = $dQue->paginate();
        return view('apps.platform.product.venue.list')
            ->with('rows', $venues)
            ->with('query', $query);
    }

    /**
     * 保存场馆
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postStore()
    {
        $id = \request('id', 0);
        $name = \request('name');
        $phone = \request('phone');
        $mobile = \request('mobile');
        $area = \request('area_id');
        $street = \request('street');
        $latitude = \request('latitude');
        $longitude = \request('longitude');
        $desc = \request('description') ?: '';


        if (!$name || $area <= 0) {
            $msg = '场馆名称、归属地不能为空！';
        } else {
            $values = [
                'name' => $name,
                'phone' => $phone,
                'mobile' => $mobile,
                'area_id' => $area,
                'street' => $street,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'description' => $desc
            ];
            if ($id > 0) {
                $state = \DB::table('bas_category')
                    ->where('id', $id)
                    ->update($values);
            } else {
                $state = \DB::table('bas_category')
                    ->insert($values);
            }
            if ($state) {
                return self::retSuc();
            }
        }

        return self::retErr($msg ?? '场馆保存失败！');
    }

    /**
     * 编辑场馆信息
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEdit($id)
    {
        $venue = \DB::table('bas_category')->where('id', $id)->first();

        return view(app_view('product.venue.edit'))->with('venue', $venue);
    }

    /**
     * 删除场馆
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDestroy($id)
    {
        $venue = \DB::table('bas_venue')->where('id', $id)->first();
        if ($venue) {
            if (\DB::table('bas_venue_category')->where('venue_id', $id)->count() > 0 ||
                \DB::table('inv_product')->where('venue_id', $id)->count() > 0) {
                $msg = '场馆正在被使用禁止删除！';
            } else {
                \DB::table('bas_venue')->where('id', $id)->delete();
                return back();
            }
        } else {
            $msg = '场馆不存在！';
        }

        return back()->withErrors($msg ?? '删除场馆失败！');
    }
}
