<?php

use Illuminate\Database\Seeder;
use App\Models\Items;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Items::create([
            "name"      => "Tepung",
            "unit"      => "KG"
        ]);

        Items::create([
            "name"      => "Beras",
            "unit"      => "KG"
        ]);

        Items::create([
            "name"      => "Gula",
            "unit"      => "KG"
        ]);

        Items::create([
            "name"      => "Kecap",
            "unit"      => "KG"
        ]);

        Items::create([
            "name"      => "Sambal",
            "unit"      => "KG"
        ]);

        Items::create([
            "name"      => "Garam",
            "unit"      => "KG"
        ]);
        Items::create(['name' => 'Minyak Goreng',
        			  'unit' => 'liter']);

        Items::create(['name' => 'Telur',
        			  'unit' => 'kg']);

        Items::create(['name' => 'Bawang',
        			  'unit' => 'ons']);
    }
}
