<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SupplyChain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 场馆联系人
        Schema::create('sc_supplier', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('venue_id')->comment('场馆');
            $table->string('name')->comment('姓名');
            $table->string('mobile', 20)->comment('手机');
            $table->string('password')->comment('密码');
            $table->string('openid')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
        // 分销商
        Schema::create('sc_distributor', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('分销商名字');
            $table->string('mobile', 20)->comment('手机号');
            $table->string('password')->comment('密码');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sc_distributor');
        Schema::dropIfExists('sc_supplier');
    }
}
