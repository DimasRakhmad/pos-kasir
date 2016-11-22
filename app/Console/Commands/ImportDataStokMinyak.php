<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Accounts;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\Tank;
use Excel;

class ImportDataStokMinyak extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:stokminyak';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Stok Minyak';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = Excel::load('data-stok-minyak.xlsx')->all();

        $purchase_account = new Accounts();
        $purchase_account->group_id = 9;
        $purchase_account->name = "Pembelian Minyak Sawit";
        $purchase_account->save();

        $sale_account = new Accounts();
        $sale_account->group_id = 1;
        $sale_account->name = "Penjualan Minyak Sawit";
        $sale_account->save();

        $barang = new Barang();
        $barang->name = "Minyak Sawit";
        $barang->unit = "kg";
        $barang->shrink = 1;
        $barang->purchase_account_id = $purchase_account->id;
        $barang->sale_account_id = $sale_account->id;
        $barang->save();

        foreach ($file as $key => $reader) {
            $name = $reader->tangki;
            $driver = $reader->driver;
            $amount = $reader->stok;

            $tank = new Tank();
            $tank->name = $name;
            $tank->driver = $driver;
            if (substr($name,-6,6) == "Gudang") $tank->stock = 1;
            else $tank->stock = 0;
            $tank->save();

            $stok = new Gudang();
            $stok->item_id = $barang->id;
            $stok->amount_in = $amount;
            $stok->type = "Masuk";
            $stok->tank_id = $tank->id;
            $stok->notes = "Data Stok Awal ".$name;
            $stok->save();
        }
    }
}
