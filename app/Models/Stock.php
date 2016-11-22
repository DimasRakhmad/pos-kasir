<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table ='stocks';

    public function item() {
        return $this->belongsTo('App\Models\Items','item_id');
    }
}
