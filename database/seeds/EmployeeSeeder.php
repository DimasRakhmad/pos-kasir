<?php

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Account;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Account::create([
            "id"            => 8,
            "name"          => "Piutang Iqbal",
            "account_group_id"      => 10
        ]);

        Employee::create([
            'name'          => 'Iqbal',
            'position'     	=> 'admin',
            'account_id'    => 4
        ]);

        Account::create([
            "id"            => 9,
            "name"          => "Piutang Nico",
            "account_group_id"      => 10
        ]);
        
        Employee::create([
            'name'          => 'Nico',
            'position'     	=> 'admin',
            'account_id'    => 5
        ]);

        Account::create([
            "id"            => 10,
            "name"          => "Piutang Tyto",
            "account_group_id"      => 10
        ]);
        
        Employee::create([
            'name'          => 'Tyto',
            'position'     	=> 'admin',
            'account_id'    => 6
        ]);

        Account::create([
            "id"            => 11,
            "name"          => "Piutang Dimas",
            "account_group_id"      => 10
        ]);
        
        Employee::create([
            'name'          => 'Dimas',
            'position'     	=> 'admin',
            'account_id'    => 7
        ]);
    }
}
