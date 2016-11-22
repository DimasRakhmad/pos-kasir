<?php

use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //
        // DB::table('tables')->truncate();

        $table = [
            ['id' => 1, 'code' => 'M001', 'area_id' => 1 , 'name' => 'Meja 1', 'created_at' => \Carbon\Carbon::now()],
            ['id' => 2, 'code' => 'M002', 'area_id' => 2, 'name' => 'Meja 2', 'created_at' => \Carbon\Carbon::now()],
            ['id' => 3, 'code' => 'M003', 'area_id' => 1, 'name' => 'Meja 3', 'created_at' => \Carbon\Carbon::now()],
            ['id' => 4, 'code' => 'M004', 'area_id' => 3, 'name' => 'Meja 4', 'created_at' => \Carbon\Carbon::now()],
            ['id' => 999, 'code' => 'M999', 'area_id' => 3, 'name' => 'Di Bawa Pulang', 'created_at' => \Carbon\Carbon::now()]
        ];

        // insert batch
        DB::table('tables')->insert($table);
    }
}
