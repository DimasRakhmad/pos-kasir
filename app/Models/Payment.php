<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Payment extends Model
{
    //
    
    protected $table ='banks';
    protected $fillable = array('id','name','account_id');
    
    protected $primaryKey = 'id';

    public function account(){
    	return $this->belongsTo('App\Models\Accounts','account_id','id');
    }
}
