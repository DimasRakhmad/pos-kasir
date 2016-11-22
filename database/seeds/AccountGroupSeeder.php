<?php

use Illuminate\Database\Seeder;
use App\Models\AccountGroup;

class AccountGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        //1
        AccountGroup::create([
        	"id"				=> 1,
        	"name" 				=> "Pendapatan Usaha",
        	"normal_balance" 	=> "Kredit",
            "category"          => "Pendapatan"
        ]);
        // 2
        AccountGroup::create([
        	"id"				=> 2,
            "name"              => "Biaya Produksi",
            "normal_balance"    => "Debit",
            "category"          => 'Biaya dan Beban'
        ]);
        // 3
        AccountGroup::create([
        	"id"				=> 3,
            "name"              => "Biaya Operasional",
            "normal_balance"    => "Debit",
            "category"          => 'Biaya dan Beban'
        ]);
        // 4
        AccountGroup::create([
        	"id"				=> 4,
            "name"              => "Biaya Non Operasional",
            "normal_balance"    => "Debit",
            "category"          => "Biaya dan Beban"
        ]);
        // 5
        AccountGroup::create([
        	"id"				=> 5,
            "name"              => "Pendapatan Luar Usaha",
            "normal_balance"    => "Kredit",
            "category"          => "Pendapatan"
        ]);
        // 6
        AccountGroup::create([
        	"id"				=> 6,
            "name"              => "Kas",
            "normal_balance"    => "Debit",
            "category"          => "Harta"
        ]);
        // 7
        AccountGroup::create([
        	"id"				=> 7,
            "name"              => "Kewajiban",
            "normal_balance"    => "Kredit",
            "category"          => "Hutang"
        ]);
        // 8
        AccountGroup::create([
        	"id"				=> 8,
            "name"              => "Piutang",
            "normal_balance"    => "Debit",
            "category"          => "Harta"
        ]);
        // 10
        AccountGroup::create([
        	"id"				=> 9,
            "name"              => "Kas Bank",
            "normal_balance"    => "Debit",
            "category"          => "Harta"
        ]);
         // 8
        AccountGroup::create([
            "id"                => 10,
            "name"              => "Piutang Karyawan",
            "normal_balance"    => "Debit",
            "category"          => "Harta"
        ]);
    }
}
