<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Transactions extends Model
{
    //

    protected $table = 'transactions';
    protected $fillable = array('id', 'code', 'note', 'meja_id', 'discon', 'amount', 'date');
    protected $primaryKey = 'id';
    protected $casts = [
        'note' => 'array',
    ];

    public function detail() {
        return $this->hasMany('App\Models\TransactionDetails','transaction_id');
    }

    public function transactionDetails()
    {
        return $this->hasMany('App\Models\DetailTransaksi', 'transaction_id');
    }

    public function accounting()
    {
        return $this->hasMany('App\Models\AccountingTransaction', 'transaction_id');
    }

    public function sales()
    {
        return $this->hasOne('App\Models\Sale', 'transaction_id');
    }

    public function purchase()
    {
        return $this->hasOne('App\Models\Purchase', 'transaction_id');
    }

    // public function account()
    // {
    //     return $this->belongsToMany('App\Models\Accounts', 'transaction_details', 'transaction_id', 'account_id')->withPivot('amount', 'keterangan')->withTimestamps();
    // }

    public function table()
    {
        return $this->belongsTo('App\Models\Table', 'meja_id');
    }
    public function bank()
    {
        return $this->belongsTo('App\Models\Bank', 'bank_id');
    }

    // public function gudang() {
    //     return $this->hasManyThrough('App\Models\Gudang','App\Models\TransactionDetails');
    // }

    // public function barang(){
    //     return $this->hasManyThrough('App\Models\Barang','App\Models\TransactionDetails','transaction_id','id');
    // }

    // Mengambil code terakhir
//    public static function getSysCode()
//    {
//        $t = Transactions::whereRaw("left(transaction_code,5)='SYS-G'")->orderBy('id', 'desc')->first();
//        if (!$t) $number = 1;
//        else $number = (int)substr($t->transaction_code, 6, 5) + 1;
//        return "SYS-G-" . sprintf("%05d", $number);
//    }
//
//    public static function getSysCodeGiro()
//    {
//        $t = Transactions::whereRaw("left(transaction_code,6)='SYS-GI'")->orderBy('id', 'desc')->first();
//        if (!$t) $number = 1;
//        else $number = (int)substr($t->transaction_code, 7, 5) + 1;
//        return "SYS-GI-" . sprintf("%05d", $number);
//    }
//
//    public static function getCode($code)
//    {
//        $jumlah = strlen($code);
//        $t = Transactions::whereRaw("left(transaction_code,$jumlah)='$code'")->orderBy('id', 'desc')->first();
//        if (!$t) $number = 1;
//        else $number = (int)substr($t->transaction_code, $jumlah + 1, 5) + 1;
//        return $code . "-" . sprintf("%05d", $number);
//    }
}
