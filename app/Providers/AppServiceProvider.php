<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use App\Models\Kegiatan;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // $notif = DB::table('transaction_details')
        // ->join('transactions', 'transactions.id','=','transaction_details.transaction_id')
        // ->join('accounts', 'accounts.id', '=', 'transaction_details.account_id')
        // ->join('partner','partner.account_id','=','accounts.id')
        // ->whereRaw('datediff(DATE_ADD(transaction_date,INTERVAL partner.payment_deadline DAY),now()) <= 1')
        // ->whereRaw('datediff(DATE_ADD(transaction_date,INTERVAL partner.payment_deadline DAY),now()) > -1')
        // ->where('transactions.status',-1)
        // ->orderBy('transactions.transaction_date')
        // ->selectRaw('transactions.id as id, partner.name as name, partner.type as type,transaction_details.amount as amount,datediff(DATE_ADD(transaction_date,INTERVAL partner.payment_deadline DAY),now()) as deadline')
        // ->get();
        // $cekAbsen = Kegiatan::where('tanggal',date('Y-m-d'))->get();
        // view()->share(['notif'=>$notif,'count'=>count($notif),'cekAbsen'=>$cekAbsen]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
