<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StockSchemaV171214 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 地区
        Schema::create('bas_area', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('地区名称');
            $table->string('citycode')->comment('城市编码');
            $table->string('adcode')->comment('区域编码');
            $table->string('latitude')->comment('纬度');
            $table->string('longitude')->comment('经度');
            $table->string('level')->comment('行政区划级别');
            $table->unsignedInteger('typeid')->default(0);
            $table->smallInteger('level_count')->default(0);
        });
        // 场馆
        Schema::create('bas_venue', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone')->nullable()->comment('电话');
            $table->string('mobile')->nullable()->comment('手机');
            $table->text('description')->nullable();
            $table->text('traffic')->nullable();
            $table->unsignedInteger('area_id')->default(0)->comment('地区');
            $table->string('street')->nullable()->comment('详细街道');
            $table->string('latitude')->nullable()->comment('纬度');
            $table->string('longitude')->nullable()->comment('经度');
        });
        // 产品类目
        Schema::create('bas_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('类目名称');
            $table->unsignedInteger('pid')->default(0)->comment('父级类目');
        });
        // 场馆适用类目
        Schema::create('bas_venue_category', function (Blueprint $table) {
            $table->unsignedInteger('venue_id')->comment('场馆');
            $table->unsignedInteger('category_id')->comment('类目');
        });
        // 类目属性名
        Schema::create('bas_category_attr', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attr_name', 100);
            $table->string('attr_note', 100)->nullable();
            $table->unsignedInteger('category_id')->comment('所属类目');
            $table->unsignedInteger('attr_sort')->default(0);
        });
        // 产品资料(SPU)
        Schema::create('inv_product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('category_id')->comment('类目');
            $table->unsignedInteger('venue_id')->default(0)->comment('场馆');
            $table->timestamps();
        });
        // 产品库存SKU
        Schema::create('inv_stock', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->comment('产品');
            $table->string('sku_note')->nullable()->comment('sku名称');
            $table->string('sku_code')->nullable()->comment('sku编码');
            $table->unsignedInteger('sku_num')->default(0)->comment('库存');
            $table->decimal('sku_price', 18, 2)->default(0.00)->comment('价格');
            $table->decimal('sku_cost', 18, 2)->default(0.00)->comment('成本');
            $table->text('sku_eles')->nullable()->comment('sku元素');

            $table->unique('sku_code');
        });
        // 产品库存属性
        Schema::create('inv_stock_attr', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->comment('产品');
            $table->unsignedInteger('sku_id')->comment('库存');
            $table->unsignedInteger('attr_id')->comment('SKU属性');
            $table->string('attr_value')->comment('属性值');

            $table->unique(['sku_id', 'attr_id'], 'unique_sku_attr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_stock_attr');
        Schema::dropIfExists('inv_stock');
        Schema::dropIfExists('inv_product');
        Schema::dropIfExists('bas_category_attr');
        Schema::dropIfExists('bas_venue_category');
        Schema::dropIfExists('bas_category');
        Schema::dropIfExists('bas_venue');
        Schema::dropIfExists('bas_area');
    }
}
