<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    //
    protected $table ='employees';
    protected $fillable = array('id','nama','alamat','no_hp','gaji_pokok','upah_lembur','uang_makan','potongan_absen');
    
    protected $primaryKey = 'id';
    
    public function absen(){
        return $this->hasMany('App\Models\Absen','employee_id','id');
    }
}
