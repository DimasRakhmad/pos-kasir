<?php

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create([
		    'name' => 'Atas',
		]);

		Area::create([
		    'name' => 'Depan',
		]);

		Area::create([
		    'name' => 'Bawah',
		]);
    }
}
