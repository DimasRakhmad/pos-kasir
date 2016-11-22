<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    //
    protected $table ='partner';
    protected $fillable = array('id','name','company','phone','payment_deadline','type','account_id');
    protected $primaryKey = 'id';

    public function account(){
    	return $this->belongsTo('App\Models\Accounts','account_id','id');
    }

    public function gudang() {
        return $this->hasMany('App\Models\Gudang','partner_id');
    }
}
