<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaction';
    protected $fillable = array('id', 'transaction_id', 'note', 'items_id', 'discon', 'amount', 'qty');
    protected $primaryKey = 'id';

    public function trans()
    {
        return $this->belongsToMany('App\Models\Transaksi', 'transaction_id');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Items', 'items_id');
    }
}
