<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Giro;
use App\Models\Transactions;
use App\Models\TransactionDetails;
use Excel;

class ImportDataGiro extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:giro';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Data Giro';

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
        $file = Excel::load('data-giro.xlsx')->all();

        $transaction = new Transactions();
        $transaction->transaction_code = "SYS-IMPORT-GIRO";
        $transaction->name = "SYS Data Awal Giro";
        $transaction->transaction_date = date("Y-m-d");
        $transaction->save();

        foreach ($file as $key => $reader) {
            $no_giro = $reader->no_giro;
            $nominal = $reader->nominal;
            $tanggal_dibuat = date('Y-m-d', strtotime($reader->tanggal_dibuat));
            $tanggal_efektif = date('Y-m-d', strtotime($reader->tanggal_efektif));
            $nama_bank = $reader->nama_bank;

            $giro = new Giro();
            $giro->no_giro = $no_giro;
            $giro->nominal = $nominal;
            $giro->tanggal_dibuat = $tanggal_dibuat;
            $giro->tanggal_efektif = $tanggal_efektif;
            $giro->nama_bank = $nama_bank;
            $giro->status = 1;
            $giro->save();

            $detail = new TransactionDetails();
            $detail->transaction_id = $transaction->id;
            $detail->account_id = 2;
            $detail->amount = $nominal;
            $detail->keterangan = "Data Awal Giro (".$no_giro.")";
            $detail->save();
        }
    }
}
