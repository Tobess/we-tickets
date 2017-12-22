<?php

use Illuminate\Database\Seeder;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ('Yes' == $this->command->choice('你确定要更新地区数据库吗？', ['No', 'Yes'], 0)) {
            $path = database_path('sqls/areas.sql');
            $sqlArr = explode("\n", file_get_contents($path));
            if (count($sqlArr) > 0) {
                DB::transaction(function () use ($sqlArr) {
                    DB::table('bas_area')->delete();
                    foreach ($sqlArr as $sql) {
                        DB::statement($sql);
                    }
                });
            }
        }
    }
}
