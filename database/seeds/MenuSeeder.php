<?php

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // DB::table('items')->truncate();

        $menu = [
            ['id' => 1, 'category_id' => '1', 'code' => 'A001', 'price' => '10000', 'name' => 'Kentang Goreng', 'created_at' => \Carbon\Carbon::now()],
            ['id' => 2, 'category_id' => '1', 'code' => 'A002', 'price' => '20000', 'name' => 'Tempe Mendoan', 'created_at' => \Carbon\Carbon::now()],
            ['id' => 3, 'category_id' => '2', 'code' => 'MC001', 'price' => '30000', 'name' => 'Nasi Goreng', 'created_at' => \Carbon\Carbon::now()],
            ['id' => 4, 'category_id' => '2', 'code' => 'MC002', 'price' => '40000', 'name' => 'Mie Ayam', 'created_at' => \Carbon\Carbon::now()],
            ['id' => 5, 'category_id' => '3', 'code' => 'D001', 'price' => '25000', 'name' => 'Puding', 'created_at' => \Carbon\Carbon::now()],
            ['id' => 6, 'category_id' => '3', 'code' => 'D002', 'price' => '15000', 'name' => 'Pancake', 'created_at' => \Carbon\Carbon::now()],
            ['id' => 7, 'category_id' => '4', 'code' => 'B001', 'price' => '15000', 'name' => 'Jus Semangka', 'created_at' => \Carbon\Carbon::now()],
            ['id' => 8, 'category_id' => '4', 'code' => 'B002', 'price' => '15000', 'name' => 'Lemon Tea', 'created_at' => \Carbon\Carbon::now()],
        ];

        // insert batch
        DB::table('menus')->insert($menu);
    }
}
