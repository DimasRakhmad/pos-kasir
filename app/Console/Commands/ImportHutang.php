<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Partner;
use App\Models\Transactions;
use App\Models\TransactionDetails;
use Excel;

class ImportHutang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:hutang';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Data Hutang';

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
        $file = Excel::load('data-hutang.xlsx')->all();

        foreach ($file as $key => $reader) {
            $name = $reader->name;

            $supplier = Partner::where('type', 'Supplier')->where('company', $name)->first();

            $amount = $reader->amount;
            $transaction_date = strtotime($reader->deadline." -".$supplier->payment_deadline." days");
            $transaction_code = $reader->transaction_code;

            $transaction = new Transactions();
            $transaction->transaction_code = "SYS-".$transaction_code;
            $transaction->name = "SYS Data Hutang ".$transaction_code;
            $transaction->status = -1;
            $transaction->transaction_date = date("Y-m-d", $transaction_date);
            $transaction->partner_id = $supplier->id;
            $transaction->save();

            $details = new TransactionDetails();
            $details->transaction_id = $transaction->id;
            $details->account_id = $supplier->account_id;
            $details->amount = $amount*-1;
            $details->keterangan = "Data Awal Hutang ".$name."-".$transaction_code;
            $details->save();
        }
    }
}
