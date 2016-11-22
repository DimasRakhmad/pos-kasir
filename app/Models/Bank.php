<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    //
    protected $table ='banks';
    protected $fillable = array('id','name');
    protected $primaryKey = 'id';
}
