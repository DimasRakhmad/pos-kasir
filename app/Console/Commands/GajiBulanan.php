<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Karyawan;
use App\Models\Transactions;
use App\Models\TransactionDetails;
use App\Models\Gaji;
use App\Models\Kegiatan;
use DB;
use Carbon\Carbon;

class GajiBulanan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gaji:bulanan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //

        // $date = date("Y-m");
        $date = Carbon::now();
        $date = $date->subMonth();
        $datefull = $date->toDateString();
        $date = $date->format("Y-m");

        $transaction = Transactions::with('account')->whereRaw("DATE_FORMAT(transaction_date,'%Y-%m') = '$date'")->where('name','like','Kasbon%')->get();
        // return $transaction;

        $karyawan = Karyawan::where('type','Bulanan')->get();

        foreach ($karyawan as $key) {
            $absen = DB::table('attendance')->join('activities','activities.id','=','attendance.activity_id')
                ->whereRaw("DATE_FORMAT(activities.tanggal,'%Y-%m') = '$date'")
                ->where('attendance.employee_id',$key->id)
                // ->where('activities.status',0)
                ->select('attendance.*')
                ->get();
            $key['absen'] = $absen;
            $tran = array();
            foreach ($transaction as $key2) {
                # code...

                $note = json_decode($key2->notes, true);
                if($note['employee_id'] == $key->id){
                    $tran[] = $key2;
                }
            }

            $key['tran']=$tran;

            // Ganti status Activities menjadi sudah digenerate
            $activities = Kegiatan::find($absen->id_activites);
            $activities->status = 1;
            $activities->save();
        }
        $data = array();
        $i=0;

        // Hitung jumlah kasbon
        $total_gaji_pokok       = 0;
        $total_upah_lembur      = 0;
        $total_uang_makan       = 0;
        $total_potongan_absen   = 0;
        $total_potongan_kasbon  = 0;
        $total_gaji_keseluruhan = 0;

        foreach ($karyawan as $kar) {
            # code...
            $tidak = 0;
            $lembur = 0;
            $kasbon = 0;
            $hadir = 0;
            $uang_lembur = 0;
            $uang_makan_lembur =0;
            // Hitung jumlah absen dan lembur
            foreach ($kar->absen as $absen) {
                if($absen->status == "Tidak"){
                    $tidak++;
                }elseif ($absen->status == "Lembur") {
                    if($absen->notes){
                        $note = json_decode($absen->notes, true);
                        if($note['tipe_lembur']==1){
                            $uang_lembur+=4000;
                        }elseif ($note['tipe_lembur']==2) {
                            # code...
                            $uang_lembur+=5000;
                        }elseif ($note['tipe_lembur']==3) {
                            # code...
                            $uang_lembur+=5000;
                            $uang_makan_lembur+=10000;
                        }
                    }
                    
                    $lembur++;
                    $hadir++;
                }elseif ($absen->status == "Hadir") {
                    $hadir++;
                }
            }
            foreach ($kar->tran as $tran) {
                foreach ($tran->account as $account) {
                    if($account->id == 7){
                        $kasbon+=$account->pivot->amount;
                    }
                }
            }
            $gaji                  = new Gaji();
            $gaji->tanggal         = date("Y-m-d");
            $gaji->employee_id     = $kar->id;
            $gaji->gaji_pokok      = $kar->gaji_pokok;
            $gaji->upah_lembur     = $uang_lembur;
            $gaji->uang_makan      = ($kar->uang_makan*$hadir)+$uang_makan_lembur;
            $gaji->potongan_absen  = $kar->potongan_absen*$tidak;
            $gaji->potongan_kasbon = $kasbon;
            $gaji->total_gaji      = ($kar->gaji_pokok+$uang_lembur+$uang_makan_lembur+($kar->uang_makan*$hadir)-($tidak*$kar->potongan_absen)-$kasbon);
            $i++;
            $gaji->save();
            // Akumulasi
            $total_gaji_pokok       += $kar->gaji_pokok;
            $total_upah_lembur      += $uang_lembur;
            $total_uang_makan       += ($kar->uang_makan*$hadir)+$uang_makan_lembur;
            $total_potongan_absen   += ($kar->potongan_absen*$tidak);
            $total_potongan_kasbon  += $kasbon;
            $total_gaji_keseluruhan += ($kar->gaji_pokok+$uang_lembur+$uang_makan_lembur+($kar->uang_makan*$hadir)-($tidak*$kar->potongan_absen)-$kasbon);
        }

        $transaction                   = new Transactions();
        $transaction->name             = "Penggajian ".$date;
        $transaction->transaction_code = Transactions::getSysCode();
        $transaction->transaction_date = date("Y-m-d");
        $transaction->save();

        // Kredit Akun BCA (total gaji pokok - total potongan absen - total potongan kasbon).
        $tran = new TransactionDetails();
        $tran->transaction_id = $transaction->id;
        $tran->account_id     = 10;
        $tran->amount         = -1*($total_gaji_pokok - $total_potongan_absen - $total_potongan_kasbon);
        $tran->keterangan     = "Total Gaji";
        $tran->save();

        //  Debit Akun Biaya Gaji sejumlah (total gaji pokok - total potongan absen)
        $tran2 = new TransactionDetails();
        $tran2->transaction_id = $transaction->id;
        $tran2->account_id     = 4;
        $tran2->amount         = ($total_gaji_pokok - $total_potongan_absen);
        $tran2->keterangan     = "Total Gaji Tanpa Kasbon";
        $tran2->save();

        // Kredit Akun Piutang Karyawan sejumlah total potongan kasbon.
        $tran3 = new TransactionDetails();
        $tran3->transaction_id = $transaction->id;
        $tran3->account_id     = 4;
        $tran3->amount         = -1*$total_potongan_kasbon;
        $tran3->keterangan     ="Total Kasbon";
        $tran3->save();

        //  Kredit Akun Kas dan Debit Akun Upah Lembur sejumlah total upah lembur.
        $tran4 = new TransactionDetails();
        $tran4->transaction_id = $transaction->id;
        $tran4->account_id     = 1;
        $tran4->amount         = -1*$total_upah_lembur;
        $tran4->keterangan     ="Total Upah Lembur";
        $tran4->save();
        $tran5 = new TransactionDetails();
        $tran5->transaction_id = $transaction->id;
        $tran5->account_id     = 5;
        $tran5->amount         = $total_upah_lembur;
        $tran5->keterangan     ="Total Upah Lembur";
        $tran5->save();

        //  Kredit Akun Kas dan Debit Biaya Makan Karyawan sejumlah total uang makan.
        $tran6 = new TransactionDetails();
        $tran6->transaction_id = $transaction->id;
        $tran6->account_id     = 1;
        $tran6->amount         = -1*$total_uang_makan;
        $tran6->keterangan     ="Total Uang Makan";
        $tran6->save();
        $tran7 = new TransactionDetails();
        $tran7->transaction_id = $transaction->id;
        $tran7->account_id     = 6;
        $tran7->amount         = $total_uang_makan;
        $tran7->keterangan     ="Total Uang Makan";
        $tran7->save();

        
    }
}
