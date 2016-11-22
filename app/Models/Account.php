<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = array('id','name','account_group_id');
   	public function accounting() {
        return $this->hasMany('App\Models\AccountingTransaction','account_id');
    }
}
