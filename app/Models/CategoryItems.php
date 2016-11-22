<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryItems extends Model
{
    //
    protected $table = 'categories';
    protected $fillable = array('id', 'name','description');
    protected $primaryKey = 'id';
}
