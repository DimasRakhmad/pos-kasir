<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Karyawan;

use Excel;

class ImportDataKaryawan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:karyawan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Data Karyawan';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = Excel::load('data-karyawan.xlsx')->all();

        foreach ($file as $key => $reader) {
            $type = $reader->tipe;
            $nama = $reader->nama;
            $alamat = $reader->alamat;
            $hp = $reader->hp;
            $pokok = $reader->pokok;
            $lembur = $reader->lembur;
            $makan = $reader->makan;
            $absen = $reader->absen;

            $karyawan = new Karyawan();
            $karyawan->type = $type;
            $karyawan->nama = $nama;
            $karyawan->alamat = $alamat;
            $karyawan->no_hp = $hp;
            $karyawan->gaji_pokok = $pokok;
            $karyawan->upah_lembur = $lembur;
            $karyawan->uang_makan = $makan;
            $karyawan->potongan_absen = $absen;
            $karyawan->save();
        }
    }
}
