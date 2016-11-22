<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public function transaction() {
    	return $this->belongsTo('App\Models\Transactions','transaction_id','id')->orderBy('transaction_date');
    }

    public function waiter() {
    	return $this->belongsTo('App\User','waiters_id');
    }
}
