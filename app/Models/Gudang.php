<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    //
    protected $table ='stocks';
    protected $fillable = array('id','item_id','amount','price','type','tank_id','partner_id','transaction_detail_id');
    protected $primaryKey = 'id';

    public function barang() {
        return $this->belongsTo('App\Models\Barang','item_id','id');
    }
    public function tank() {
    	return $this->belongsTo('App\Models\Tank','tank_id','id');
    }
    public function transactionDetails() {
        return $this->belongsTo('App\Models\TransactionDetails','transaction_detail_id','id');
    }

    public function partner() {
        return $this->belongsTo('App\Models\Partner','partner_id','id');
    }
}
