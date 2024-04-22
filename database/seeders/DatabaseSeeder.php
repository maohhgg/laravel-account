<?php

namespace Database\Seeders;

use App\Models\TradeType;
use Illuminate\Database\Seeder;
use App\Models\Navigation;
use App\Models\Admin;
use App\Models\Page;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $now = now()->format('Y-m-d H:i:s');

        Admin::factory()->create(['name'=>'admin', 'created_at'=> $now, 'updated_at'=>$now]);

        Page::factory()->create(['name' => '会员列表','url' => 'admin.users','navigation_id' => '5']);
        Page::factory()->create(['name' => '建立新会员','url' => 'admin.users.create','navigation_id' => '5']);
        Page::factory()->create(['name' => '管理员列表','url' => 'admin.admins','navigation_id' => '6']);
        Page::factory()->create(['name' => '建立新管理员','url' => 'admin.admins.create','navigation_id' => '6']);
        Page::factory()->create(['name' => '全部数据','url' => 'admin.data','navigation_id' => '3']);
        Page::factory()->create(['name' => '类型','url' => 'admin.change','navigation_id' => '4']);
        Page::factory()->create(['name' => '新建数据','url' => 'admin.data.create','navigation_id' => '3']);
        Page::factory()->create(['name' => '历史记录','url' => 'data.history','navigation_id' => '8']);


        TradeType::factory()->create(['name' => '充值', 'is_increase' => true]);
        TradeType::factory()->create(['name' => '手续费', 'is_increase' => false]);
        TradeType::factory()->create(['name' => '消费', 'is_increase' => false]);

        Navigation::factory()->create(['action' => 'home','icon' => 'home','name' => '首页','url' => 'admin','parent_id' => '0','is_admin' => '1']);
        Navigation::factory()->create(['action' => 'menu','icon' => 'users','name' => '用户','url' => '','parent_id' => '0','is_admin' => '1']);
        Navigation::factory()->create(['action' => 'data','icon' => 'bar-chart-2','name' => '数据','url' => 'admin.data','parent_id' => '0','is_admin' => '1']);
        Navigation::factory()->create(['action' => 'change','icon' => 'trending-up','name' => '交易类型','url' => 'admin.change','parent_id' => '0','is_admin' => '1']);
        Navigation::factory()->create(['action' => 'users','icon' => 'user','name' => '会员','url' => 'admin.users','parent_id' => '2','is_admin' => '1']);
        Navigation::factory()->create(['action' => 'admins','icon' => 'lock','name' => '管理员','url' => 'admin.admins','parent_id' => '2','is_admin' => '1']);
        Navigation::factory()->create(['action' => 'home','icon' => 'home','name' => '首页','url' => 'home','parent_id' => '0','is_admin' => '0']);
        Navigation::factory()->create(['action' => 'history','icon' => 'pie-chart','name' => '历史记录','url' => 'data.history','parent_id' => '0','is_admin' => '0']);
    }
}
