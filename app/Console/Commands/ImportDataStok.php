<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Accounts;
use App\Models\Barang;
use App\Models\Gudang;
use Excel;

class ImportDataStok extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:stok';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data stok barang';

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
        $file = Excel::load('data-stok-barang.xlsx')->all();

        foreach ($file as $key => $reader) {
            $name = $reader->nama;
            $satuan = $reader->satuan;
            $amount = $reader->stok;

            $purchase_account = new Accounts();
            $purchase_account->group_id = 9;
            $purchase_account->name = "Pembelian ".$name;
            $purchase_account->save();

            $sale_account = new Accounts();
            $sale_account->group_id = 1;
            $sale_account->name = "Penjualan ".$name;
            $sale_account->save();

            $barang = new Barang();
            $barang->name = $name;
            $barang->unit = $satuan;
            $barang->shrink = 0;
            $barang->purchase_account_id = $purchase_account->id;
            $barang->sale_account_id = $sale_account->id;
            $barang->save();

            $stok = new Gudang();
            $stok->item_id = $barang->id;
            $stok->amount_in = $amount;
            $stok->type = "Masuk";
            $stok->notes = "Data Stok Awal ".$name;
            $stok->save();
        }
    }
}
