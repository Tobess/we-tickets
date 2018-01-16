<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStockV180104 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_product', function (Blueprint $table) {
            $table->unsignedInteger('item_type')->default(0)->comment('商品类型'); // 0-普通 60-虚拟 61-电子卡券 35-酒店商品
            $table->text('desc')->nullable()->comment('描述');
            $table->decimal('price', 18, 2)->default(0)->comment('价格');
            $table->decimal('origin_price', 18, 2)->default(0)->comment('原价');
            $table->unsignedInteger('quantity')->default(0)->comment('总库存');
            $table->string('item_no')->nullable()->comment('商品编码');
            $table->decimal('item_cost', 18, 2)->default(0)->comment('成本价');
            $table->tinyInteger('star')->default(0)->comment('上架类型');//0立即上架售卖1自定义上架时间2暂不售卖，放入仓库
            $table->string('star_time')->nullable()->comment('上架时间');//自定义上架时间
            $table->longText('richtext')->nullable()->comment('商品富文本详情');
        });
        // 产品库存属性
        Schema::table('inv_stock_attr', function (Blueprint $table) {
            $table->dropIndex('unique_sku_attr');
            $table->string('attr_title')->comment('属性名');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
