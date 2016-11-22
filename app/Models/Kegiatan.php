<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    //
    protected $table ='activities';
    protected $fillable = array('id','user_id','tanggal');
    protected $primaryKey = 'id';

    public function absen(){
        return $this->hasMany('App\Models\Absen','activity_id','id');
    }

    public function user(){
    	return $this->belongsTo('App\User','user_id','id');
    }
}
