<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Accounts;
use App\Models\Partner;
use Excel;

class ImportDataCustomer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:customer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Customer Data';

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
        $file = Excel::load('data-customer.xlsx')->all();

        foreach ($file as $key => $reader) {
            $customer_name = $reader->nama;
            $cp = $reader->cp;
            $hp = $reader->hp;
            $deadline = $reader->deadline;

            $account = new Accounts();
            $account->group_id = 8;
            $account->name = "Piutang ".$customer_name;
            $account->save();

            $partner = new Partner();
            $partner->name = $cp;
            $partner->company = $customer_name;
            $partner->phone = $hp;
            $partner->payment_deadline = $deadline;
            $partner->type = "Customer";
            $partner->account_id = $account->id;
            $partner->save();

        }
    }
}
