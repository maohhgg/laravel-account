<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminsTableSeeder::class,
            ServerConfigsTableSeeder::class,
            ChangeTypesTableSeeder::class,
            NavigationsTableSeeder::class,
            ChangeActionsTableSeeder::class,
            OrderStatusTableSeeder::class,
        ]);
    }
}
