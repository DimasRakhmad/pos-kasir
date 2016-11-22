<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EDC extends Model
{
    protected $table = 'edcs';
    protected $fillable = array('id','name','account_kredit_id','account_debit_id');
}
