<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 分销库存
        Schema::create('inv_stock_dist', function (Blueprint $table) {
            $table->increments('sd_id');
            $table->unsignedInteger('dist_id')->comment('分销商ID');
            $table->unsignedInteger('product_id')->comment('产品ID');
            $table->unsignedInteger('stock_id')->comment('库存ID');
            $table->unsignedInteger('sku_num')->default(0)->comment('分销数量');
            $table->decimal('sku_price')->default(0)->comment('分销价格');
            $table->unsignedInteger('dist_total')->default(0)->comment('分销总数');
            $table->unique(['dist_id', 'product_id', 'stock_id'], 'unique_dist_item_stock');
            $table->timestamps();
        });
        // 订单单据
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dist_id')->comment('分销商ID');
            $table->string('code')->unique()->comment('订单编号');
            $table->tinyInteger('channel')->default(0)->comment('订单渠道0-自有1-有赞');
            $table->string('client_mobile')->comment('客户手机号');
            $table->string('client_name')->comment('客户姓名');
            $table->string('client_identify')->comment('客户证件号');
            $table->dateTime('exchanged_at')->comment('交易时间');
            $table->dateTime('charge_back_at')->comment('退单时间');
            $table->timestamps();
        });
        // 订单商品
        Schema::create('orders_table', function (Blueprint $table) {
            $table->unsignedInteger('order_id')->comment('订单ID');
            $table->unsignedInteger('product_id')->comment('产品ID');
            $table->unsignedInteger('stock_id')->comment('库存ID');
            $table->unsignedInteger('sd_id')->comment('分销库存ID');
            $table->unsignedInteger('number')->comment('销售数量');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
