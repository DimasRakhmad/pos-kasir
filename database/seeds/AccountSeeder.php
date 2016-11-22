<?php

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Harta 100 – 199
     * Utang 200 – 299
     * Modal 300 – 399
     * Pendapatan 400 – 499
     * Beban 500 – 599
     * @return void
     */
    public function run()
    {
        //1
        Account::create([
            "id"               => 1,
            "code"             => "101",
            "name"             => "Kas",
            "account_group_id" => 6,
        ]);
        // 3 Pembelian
        Account::create([
            "id"               => 2,
            "name"             => "Pembelian",
            "code"             => "501",
            "account_group_id" => 2,
        ]);
        // 4 Penjualan
        Account::create([
            "id"               => 3,
            "code"             => "401",
            "name"             => "Penjualan",
            "account_group_id" => 1,
        ]);
        // 4 Penjualan
        Account::create([
            "id"               => 4,
            "code"             => "502",
            "name"             => "Compliment",
            "account_group_id" => 4,
        ]);

        // 4 Penjualan
        Account::create([
            "id"               => 5,
            "code"             => "503",
            "name"             => "Void",
            "account_group_id" => 4,
        ]);

        // 4 Penjualan
        Account::create([
            "id"               => 6,
            "code"             => "402",
            "name"             => "Administration Cost",
            "account_group_id" => 5,
        ]);

         // 4 Penjualan
        Account::create([
            "id"               => 7,
            "code"             => "403",
            "name"             => "Delivery Cost",
            "account_group_id" => 5,
        ]);
    }
}
