<?php

use Illuminate\Database\Seeder;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ('Yes' == $this->command->choice('你确定要初始化功能菜单吗？', ['No', 'Yes'], 0)) {
            $menusCfg = $this->menusCfg();
            DB::transaction(function () use ($menusCfg) {
                foreach ($menusCfg as $table => $menus) {
                    DB::table($table)->delete();
                    count($menus) && DB::table($table)->insert($menus);
                }
            });
        }
    }

    public function menusCfg()
    {
        return [
            'pms_plat_menus' => [
                ['id' => 1, 'name' => '产品', 'url' => '#', 'icon' => '', 'index' => 1, 'parent_id' => 0],
                ['id' => 2, 'name' => '类目管理', 'url' => '/platform/product/categories', 'icon' => 'fa fa-list', 'index' => 1, 'parent_id' => 1],
                ['id' => 3, 'name' => '场馆管理', 'url' => '/platform/product/venue', 'icon' => 'fa fa-building', 'index' => 2, 'parent_id' => 1],
                ['id' => 4, 'name' => '商品管理', 'url' => '/platform/product/items', 'icon' => 'fa fa-cubes', 'index' => 4, 'parent_id' => 1],
                ['id' => 5, 'name' => '销售', 'url' => '#', 'icon' => '', 'index' => 2, 'parent_id' => 0],
                ['id' => 6, 'name' => '分销商户', 'url' => '/platform/sale/distributor', 'icon' => 'fa fa-sliders', 'index' => 1, 'parent_id' => 5],
                ['id' => 7, 'name' => '销售订单', 'url' => '/platform/sale/orders', 'icon' => 'fa fa-bar-chart-o', 'index' => 2, 'parent_id' => 5],
                ['id' => 8, 'name' => '系统', 'url' => '#', 'icon' => '', 'index' => 3, 'parent_id' => 0],
                ['id' => 9, 'name' => '账户管理', 'url' => '/platform/system/users', 'icon' => 'fa fa-user', 'index' => 1, 'parent_id' => 8],
                ['id' => 10, 'name' => '供应商家', 'url' => '/platform/product/supplier', 'icon' => 'fa fa-truck', 'index' => 3, 'parent_id' => 1],
                ['id' => 11, 'name' => '分销商品', 'url' => '/platform/sale/dist-items', 'icon' => 'fa fa-code-fork', 'index' => 3, 'parent_id' => 5],
            ],
            'pms_dist_menus' => [
                ['id' => 1, 'name' => '分销管理', 'url' => '/distributor/sales', 'icon' => 'fa fa-sliders', 'index' => 1, 'parent_id' => 0],
                ['id' => 2, 'name' => '销售订单', 'url' => '/distributor/orders', 'icon' => 'fa fa-bar-chart-o', 'index' => 2, 'parent_id' => 0],
            ],
        ];
    }
}
