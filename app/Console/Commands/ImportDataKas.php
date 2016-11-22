<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Accounts;
use App\Models\Bank;
use App\Models\Transactions;
use App\Models\TransactionDetails;
use Excel;

class ImportDataKas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:kas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Data Kas dan Bank';

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
        $file = Excel::load('Kas.xlsx')->all();

        $transaction = new Transactions();
        $transaction->transaction_code = "SYS-IMPORT-KAS-DAN-BANK";
        $transaction->name = "SYS Data Awal Kas dan Bank";
        $transaction->transaction_date = date("Y-m-d");
        $transaction->save();

        foreach ($file as $key => $reader) {
            $name = $reader->nama;
            $saldo = $reader->saldo;

            if (substr($name, 0, 3) == "Kas") {
                $account = Accounts::where('name', $name)->first();
                if ($account != null) {
                    $account_id = $account->id;
                } else {
                    $account = new Accounts();
                    $account->group_id = 6;
                    $account->name = $name;
                    $account->save();
                    $account_id = $account->id;
                }
            } else {
                $bank = Bank::where('name', $name)->first();
                if ($bank != null) {
                    $account_id = $bank->account_id;
                } else {
                    $account = new Accounts();
                    $account->group_id = 6;
                    $account->name = $name;
                    $account->save();
                    $account_id = $account->id;

                    $bank = new Bank();
                    $bank->name = $name;
                    $bank->account_id = $account_id;
                    $bank->save();
                }
            }

            $detail = new TransactionDetails();
            $detail->transaction_id = $transaction->id;
            $detail->account_id = $account_id;
            $detail->amount = $saldo;
            $detail->keterangan = "Data Awal Kas dan Bank (".$name.")";
            $detail->save();
        }
    }
}
