<?php

use Illuminate\Database\Seeder;

class MenuCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // DB::table('category_items')->truncate();

        $categoryitems = [
            [
                'id'             => 1,
                'name'           => 'Appetizer',
                'print_location' => 'Dapur',
                'created_at'     => \Carbon\Carbon::now()
            ],
            [
                'id'             => 2,
                'name'           => 'Main Course',
                'print_location' => 'Dapur',
                'created_at'     => \Carbon\Carbon::now()
            ],
            [
                'id'             => 3,
                'name'           => 'Deesert',
                'print_location' => 'Dapur',
                'created_at'     => \Carbon\Carbon::now()
            ],
            [
                'id'             => 4,
                'name'           => 'Beverages',
                'print_location' => 'Bar',
                'created_at'     => \Carbon\Carbon::now()
            ]
        ];

        // insert batch
        DB::table('categories')->insert($categoryitems);
    }
}
