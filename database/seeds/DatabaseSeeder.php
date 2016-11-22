<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(MenuCategorySeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(TableSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AccountGroupSeeder::class);
        $this->call(AccountSeeder::class);
        // $this->call(EmployeeSeeder::class);
        $this->call(BankSeeder::class);
        $this->call(ItemSeeder::class);
        Model::reguard();
    }
}
