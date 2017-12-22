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
                ['id' => 2, 'name' => '类目管理', 'url' => '/platform/product/categories', 'icon' => 'view_comfy', 'index' => 1, 'parent_id' => 1],
                ['id' => 3, 'name' => '场馆管理', 'url' => '/platform/product/venue', 'icon' => 'account_balance', 'index' => 2, 'parent_id' => 1],
                ['id' => 4, 'name' => '产品管理', 'url' => '/platform/product/product', 'icon' => 'view_list', 'index' => 3, 'parent_id' => 1],
                ['id' => 5, 'name' => '销售', 'url' => '#', 'icon' => '', 'index' => 2, 'parent_id' => 0],
                ['id' => 6, 'name' => '分销商户', 'url' => '/platform/sale/distributor', 'icon' => 'people', 'index' => 1, 'parent_id' => 5],
                ['id' => 7, 'name' => '销售订单', 'url' => '/platform/sale/orders', 'icon' => 'reorder', 'index' => 2, 'parent_id' => 5],
                ['id' => 8, 'name' => '系统', 'url' => '#', 'icon' => '', 'index' => 3, 'parent_id' => 0],
                ['id' => 9, 'name' => '账户管理', 'url' => '/platform/system/users', 'icon' => 'verified_user', 'index' => 1, 'parent_id' => 8],
            ],
            'pms_dist_menus' => [
                ['id' => 1, 'name' => '分销管理', 'url' => '/distributor/sales', 'icon' => 'people', 'index' => 1, 'parent_id' => 0],
                ['id' => 2, 'name' => '销售订单', 'url' => '/distributor/orders', 'icon' => 'reorder', 'index' => 2, 'parent_id' => 0],
            ],
        ];
    }
}
