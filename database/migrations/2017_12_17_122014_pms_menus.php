<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PmsMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 供应商菜单
        Schema::create('pms_plat_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('url');
            $table->string('icon')->nullable();
            $table->unsignedInteger('index')->default(0);
            $table->unsignedInteger('parent_id')->default(0);
        });
        // 分销商菜单
        Schema::create('pms_dist_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('url');
            $table->string('icon')->nullable();
            $table->unsignedInteger('index')->default(0);
            $table->unsignedInteger('parent_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pms_plat_menus');
        Schema::dropIfExists('pms_dist_menus');
    }
}
