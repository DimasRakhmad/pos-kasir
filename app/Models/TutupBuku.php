<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutupBuku extends Model
{
    //
    protected $table ='closing_account';
    protected $fillable = array('id','tanggal','account_id','saldo');
    protected $primaryKey = 'id';

}
