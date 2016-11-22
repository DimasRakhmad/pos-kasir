<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // DB::table('users')->truncate();
        User::create([
            'name'          => 'Admin',
            'email'         => 'admin',
            'type'          => 'admin',
            'password'      => bcrypt ('admin'),
        ])->attachRole(1);

        User::create([
            'name'          => 'Kasir',
            'email'         => 'kasir',
            'type'          => 'kasir',
            'password'      => bcrypt ('kasir'),
        ])->attachRole(2);

        User::create([
            'name'          => 'Waiter',
            'email'         => 'waiter',
            'type'          => 'kasir',
            'password'      => bcrypt ('waiter'),
        ])->attachRole(3);

        User::create([
            'name'          => 'Manager',
            'email'         => 'manager',
            'type'          => 'kasir',
            'password'      => bcrypt ('manager'),
        ])->attachRole(5);
    }
}
