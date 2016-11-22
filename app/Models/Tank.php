<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    //
    protected $table ='tank';
    protected $fillable = array('id','name','driver','stock');
    protected $primaryKey = 'id';

    public function gudang() {
        return $this->hasMany('App\Models\Gudang','tank_id')->orderBy('created_at','desc');
    }

    
}
