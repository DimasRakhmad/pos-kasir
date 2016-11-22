<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Accounts;
use App\Models\Partner;
use App\Models\Transactions;
use App\Models\TransactionDetails;
use Excel;

class ImportPiutang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:piutang';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Data Piutang';

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
        $file = Excel::load('data-piutang.xlsx')->all();

        foreach ($file as $key => $reader) {
            $name = $reader->name;

            $customer = Partner::where('type', 'Customer')->where('company', $name)->first();
            if ($customer == null) {
                $account = new Accounts();
                $account->group_id = 8;
                $account->name = "Piutang ".$name;
                $account->save();

                $customer = new Partner();
                $customer->name = $name;
                $customer->company = $name;
                $customer->payment_deadline = 0;
                $customer->type = "Customer";
                $customer->account_id = $account->id;
                $customer->save();
            }

            $amount = $reader->amount;

            if ($reader->deadline == 'Cicil' || $reader->deadline == 'Hutang Lama' || $reader->deadline == 'Sisa' || $reader->deadline == '-') $transaction_date = strtotime("2026-04-23");
            else $transaction_date = strtotime($reader->deadline." -".$customer->payment_deadline." days");

            $random = rand(1001,9998);
            if ($reader->transaction_code == "-") $transaction_code = "NOCODE-".$random;
            else $transaction_code = $reader->transaction_code;

            $transaction = new Transactions();
            $transaction->transaction_code = "SYS-".$transaction_code;
            $transaction->name = "SYS Data Piutang ".$transaction_code;
            $transaction->status = -1;
            $transaction->transaction_date = date("Y-m-d", $transaction_date);
            $transaction->partner_id = $customer->id;
            $transaction->save();

            $details = new TransactionDetails();
            $details->transaction_id = $transaction->id;
            $details->account_id = $customer->account_id;
            $details->amount = $amount;
            $details->keterangan = "Data Awal Piutang ".$name."-".$transaction_code;
            $details->save();
        }
    }
}
