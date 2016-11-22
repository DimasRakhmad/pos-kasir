<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingTransaction extends Model
{
   	public function transaction() {
        return $this->belongsTo('App\Models\Transactions','transaction_id');
    }

    public function account() {
        return $this->belongsTo('App\Models\Account','account_id');
    }
}
