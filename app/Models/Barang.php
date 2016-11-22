<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    //
    protected $table ='items';
    protected $fillable = array('id','name','description');
    protected $primaryKey = 'id';

    public function gudang() {
        return $this->hasMany('App\Models\Gudang','item_id');
    }

    public function transactionDetails(){
    	return $this->hasMany('App\Models\TransactionDetails','item_id');
    }
}
