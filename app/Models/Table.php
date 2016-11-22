<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table ='tables';

    public function area() {
        return $this->belongsTo('App\Models\Area','area_id');
    }
}
