<?php

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\EDC;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $account_kredit = Account::create([
                        "name"             => "Kredit Mandiri",
                        "account_group_id" => 1
                    ]);
        $account_debit = Account::create([
                        "name"             => "Debit Mandiri",
                        "account_group_id" => 1
                    ]);
        EDC::create([
            'name' => 'Mandiri',
            'account_debit_id' => $account_debit->id,
            'account_kredit_id' => $account_kredit->id
        ]);
    }
}
