<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    //
    protected $table ='items';
    protected $fillable = array('id','unit','name');
    protected $primaryKey = 'id';

    public function stock()
    {
        return $this->hasMany('App\Models\Stock', 'item_id');
    }
}
