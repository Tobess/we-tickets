<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ('Yes' == $this->command->choice('你确定要初始化超级管理员账号吗？', ['No', 'Yes'], 0)) {
            $admin = \App\Models\User::find(1);

            $admin = $admin ?: new \App\Models\User;
            $admin->id = 1;
            $admin->name = 'Tobess';
            $admin->mobile = '13666120159';
            $admin->email = 'ho@tobess.com';
            $admin->password = bcrypt('123456');
            $admin->save();
        }
    }
}
