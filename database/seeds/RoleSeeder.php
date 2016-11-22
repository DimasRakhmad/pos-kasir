<?php

use Illuminate\Database\Seeder;
use Bican\Roles\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('roles')->truncate();
        Role::create([
        	'id'   => 1,
		    'name' => 'Admin',
		    'slug' => 'admin',
		]);

		Role::create([
			'id'   => 2,
		    'name' => 'Cashier',
		    'slug' => 'cashier',
		]);

		Role::create([
			'id'   => 3,
		    'name' => 'Waiters',
		    'slug' => 'waiters',
		]);

		Role::create([
			'id'   => 4,
		    'name' => 'Accounting',
		    'slug' => 'accounting',
		]);

		Role::create([
			'id'   => 5,
		    'name' => 'Manager',
		    'slug' => 'manager',
		]);
    }
}
