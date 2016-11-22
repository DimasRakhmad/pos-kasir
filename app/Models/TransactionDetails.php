<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    //
    protected $table ='transaction_details';
    protected $fillable = array('id','transaction_id','account_id','amount','item_id');
    protected $primaryKey = 'id';

    public function account() {
      return $this->belongsTo('App\Models\Accounts', 'account_id', 'id');
    }

    public function transaction() {
    	return $this->belongsTo('App\Models\Transactions','transaction_id','id')->orderBy('transaction_date');
    }

    public function barang(){
    	return $this->belongsTo('App\Models\Barang','item_id','id');
    }

    public function item(){
        return $this->belongsTo('App\Models\Menu','menu_id');
    }

    public function gudang(){
        return $this->hasOne('App\Models\Gudang','transaction_detail_id','id');
    }

    public function transactionDate() {
        return $this->belongsTo('App\Models\Transactions','transaction_id','id')->select('id', 'transaction_date');
    }

}
