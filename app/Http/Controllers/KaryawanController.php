<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Transactions;
use App\Models\TransactionDetails;
use App\Models\Kegiatan;
use App\Models\Absen;
use App\Models\Gaji;
use Auth;
use DB;
use Carbon\Carbon;
use Excel;
class KaryawanController extends Controller
{
    public function getGajiShow($tipe,$date){
        return Gaji::where('type',$tipe)->where('tanggal',$date)->get();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = Karyawan::all();
        return view('karyawan.index',['items'=>$items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $karyawan                 = new Karyawan();
        $karyawan->nama           = $request->input('nama');
        $karyawan->type           = $request->input('type');
        $karyawan->alamat         = $request->input('alamat');
        $karyawan->no_hp          = $request->input('no_hp');
        $karyawan->gaji_pokok     = $request->input('gaji_pokok');
        // $karyawan->upah_lembur    = $request->input('upah_lembur');
        $karyawan->potongan_absen = $request->input('potongan_absen');
        if($karyawan->save()){
            return redirect()->route('karyawan.index')->with('hijau','Tambah Data Karyawan Berhasil');
        }else{
            return redirect()->back()->with('merah','Oops! Ada masalah saat penambahan data, silahkan ulangi');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $karyawan = Karyawan::find($id);
        return view('karyawan.edit',['karyawan'=>$karyawan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $karyawan                 = Karyawan::find($id);
        $karyawan->nama           = $request->input('nama');
        $karyawan->type           = $request->input('type');
        $karyawan->alamat         = $request->input('alamat');
        $karyawan->no_hp          = $request->input('no_hp');
        $karyawan->gaji_pokok     = $request->input('gaji_pokok');
        // $karyawan->upah_lembur    = $request->input('upah_lembur');
        $karyawan->potongan_absen = $request->input('potongan_absen');
        if($karyawan->save()){
            return redirect()->route('karyawan.index')->with('hijau','Ubah Data Karyawan Berhasil');
        }else{
            return redirect()->back()->with('merah','Oops! Ada masalah saat proses pengubahan data, silahkan ulangi');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if(Karyawan::destroy($id)){
            return redirect()->route('karyawan.index')->with('hijau','Hapus Data Karyawan Berhasil');
        }else{
            return redirect()->back()->with('merah','Oops! Ada masalah saat proses penghapusan data, silahkan ulangi');
        }
    }

    public function kegiatan(){
        // $dt = Carbon::now();
        // $dt->addDays(5);
        // return $dt;

        // return $dt->endOfWeek(); 
        $kegiatanMingguan = Kegiatan::where('type','Mingguan')->orderBy('tanggal','desc')->get();
        $kegiatanBulanan = Kegiatan::where('type','Bulanan')->orderBy('tanggal','desc')->get();

        // $dateBefore = Carbon::now();
        // $dateBefore = $date->subDays(7);
        // return $cekAbsen;
        return view('karyawan.kegiatan',['mingguan'=>$kegiatanMingguan,'bulanan'=>$kegiatanBulanan]);
    }
    public function absensi(){
        $mingguan = Karyawan::where('type','Mingguan')->where('status',1)->get();
        $bulanan = Karyawan::where('type','Bulanan')->where('status',1)->get();
        return view('karyawan.absensi',['mingguan'=>$mingguan,'bulanan'=>$bulanan]);

    }

    public function absenShow($id){
        $items = Kegiatan::with('absen')->with('absen.karyawan')->find($id);
        return view('karyawan.lihatAbsen',['items'=>$items]);
    }

    public function absenEdit($id){
        // $items = Karyawan::with('absen')->with(['absen.kegiatan'=>
        //     function($query) use ($id){
        //         $query->where('activities.id',$id)->get();
        //     }])->get();
        // return $item;
        // $karyawan = Karyawan::all();
        $items = Kegiatan::with('absen')->with('absen.karyawan')->find($id);
        // return $items;
        return view('karyawan.absenEdit',['items'=>$items]);
    }

    public function absensiStore(Request $request){

        // return $request->input('tanggal');
        if($request->input('tanggal')){
            $date = date("Y-m-d", strtotime($request->input('tanggal')));
        }else{
            $date = date('Y-m-d');
        }


        // Ambil data
        $dataBulanan = $request->input('bulanan');
        $dataMingguan = $request->input('mingguan');
        // Absen Bulanan
        if($dataMingguan){
            // Mingguan
            $kegiatan          = new Kegiatan();
            $kegiatan->type    = "Mingguan";
            $kegiatan->user_id = Auth::user()->id;
            $kegiatan->tanggal = $date;
            $kegiatan->save();
            foreach ($dataMingguan as $key ) {

                $absen              = new Absen();
                $absen->employee_id = $key['karyawan_id'];
                $absen->status      = $key['status'];
                if($key['status']=="Lembur"){
                    $absen->notes   =json_encode(['tipe_lembur'=>$key['notes']]);
                }
                $absen->activity_id = $kegiatan->id;
                $absen->save();


            }
        }
        // Absen Bulanan
        if ($dataBulanan){
            // Bulanan
            $kegiatanBulanan          = new Kegiatan();
            $kegiatanBulanan->type    = "Bulanan";
            $kegiatanBulanan->user_id = Auth::user()->id;
            $kegiatanBulanan->tanggal = $date;
            $kegiatanBulanan->save();
            foreach ($dataBulanan as $key2 ) {

                $absen              = new Absen();
                $absen->employee_id = $key2['karyawan_id'];
                $absen->status      = $key2['status'];
                if($key2['status']=="Lembur"){
                    $absen->notes   =json_encode(['tipe_lembur'=>$key2['notes']]);
                }
                $absen->activity_id = $kegiatanBulanan->id;
                $absen->save();


            }
        }



        return redirect()->to(url('kegiatan'));
    }

    public function absensiUpdate($id,Request $request){
        $kegiatan = Kegiatan::find($id);

        $data = $request->input('absen');
        foreach ($data as $key ) {

                $absen              = Absen::find($key['absen_id']);
                $absen->status      = $key['status'];
                $absen->activity_id = $kegiatan->id;
                if($key['status']=="Lembur"){
                    $absen->notes=json_encode(['tipe_lembur'=>$key['notes']]);
                }
                $absen->save();


        }

        return redirect()->to(url('kegiatan'));
    }


    public function kasbon(){
        $karyawan = Karyawan::all();
        return view('karyawan.kasbon',['karyawan'=>$karyawan]);
    }
    public function kasbonStore(Request $request){
        $karyawan                      = Karyawan::find($request->input('karyawan_id'));
        $transaction                   = new Transactions();
        $transaction->name             = "Kasbon ".$karyawan->nama;
        $transaction->transaction_code = $request->input('transaction_code');
        $transaction->transaction_date = date("Y-m-d");
        $transaction->notes            = json_encode(['employee_id'=>$request->input('karyawan_id')]);
        $transaction->save();

        $tran = new TransactionDetails();
        $tran->transaction_id = $transaction->id;
        $tran->account_id     = 7;
        $tran->amount         = $request->input('amount');
        $tran->save();

        $tran2 = new TransactionDetails();
        $tran2->transaction_id = $transaction->id;
        $tran2->account_id     = 1;
        $tran2->amount         = -1*$request->input('amount');
        $tran2->save();

        return redirect()->route('karyawan.index');
    }

    public function gajiShow($tipe=NULL,$date=NULL){
        $gaji = $this->getGajiShow($tipe,$date);
        // return $gaji;
        return view('karyawan.gaji',['items'=>$gaji,'date'=>$date,'tipe'=>$tipe]);
    }

    public function gaji(){

       $gajiMingguan = Gaji::where('type',"Mingguan")->groupBy('tanggal')->orderBy('tanggal','desc')->get();
       $gajiBulanan = Gaji::where('type',"Bulanan")->groupBy('tanggal')->orderBy('tanggal','desc')->get();
       // return $gaji;
       return view('karyawan.indexGaji',['itemsMingguan'=>$gajiMingguan,'itemsBulanan'=>$gajiBulanan]);
    }

    public function sumAbsen(){
        $date = Carbon::now();
        $date = $date->format("Y-m");
        // return $date;
        $tigaBulan = array();
        for($i=0;$i<3;$i++){
            $no = date('m', strtotime('-'.$i.' month'));
            $tigaBulan[$i]['id']= $no;
            $tigaBulan[$i]['m']= date('Y-m', strtotime('-'.$i.' month'));
            if($no == "01"){
                $tigaBulan[$i]['name']="Januari";
            }elseif ($no == "02") {
                $tigaBulan[$i]['name']="Februari";
            }elseif ($no == "03") {
                $tigaBulan[$i]['name']="Maret";
            }elseif ($no == "04") {
                $tigaBulan[$i]['name']="April";
            }elseif ($no == "05") {
                $tigaBulan[$i]['name']="Mei";
            }elseif ($no == "06") {
                $tigaBulan[$i]['name']="Juni";
            }elseif ($no == "07") {
                $tigaBulan[$i]['name']="Juli";
            }elseif ($no == "08") {
                $tigaBulan[$i]['name']="Agustus";
            }elseif ($no == "09") {
                $tigaBulan[$i]['name']="September";
            }elseif ($no == "10") {
                $tigaBulan[$i]['name']="Oktober";
            }elseif ($no == "11") {
                $tigaBulan[$i]['name']="November";
            }elseif ($no == "12") {
                $tigaBulan[$i]['name']="Desember";
            }

        }
        // return $tigaBulan;
        // $date = $date->subMonth();

        $karyawan = Karyawan::where('type','Bulanan')->get();
        foreach ($karyawan as $key) {
            $absen = DB::table('attendance')->join('activities','activities.id','=','attendance.activity_id')
                ->whereRaw("DATE_FORMAT(activities.tanggal,'%Y-%m') = '$date'")
                ->where('attendance.employee_id',$key->id)
                ->where('activities.type',"Bulanan")
                ->select('attendance.*')
                ->get();
            $key['absen'] = $absen;
        }
        // return $karyawan;
        return view('karyawan.sumGaji',['items'=>$karyawan,'tigaBulan'=>$tigaBulan,'date'=>$date]);
    }

    public function sumAbsenPost(Request $request){

        $date = date('Y').'-'.$request->input('bulan');

        $tigaBulan = array();
        for($i=0;$i<3;$i++){
            $no = date('m', strtotime('-'.$i.' month'));
            $tigaBulan[$i]['id']= $no;
            $tigaBulan[$i]['m']= date('Y-m', strtotime('-'.$i.' month'));
            if($no == "01"){
                $tigaBulan[$i]['name']="Januari";
            }elseif ($no == "02") {
                $tigaBulan[$i]['name']="Februari";
            }elseif ($no == "03") {
                $tigaBulan[$i]['name']="Maret";
            }elseif ($no == "04") {
                $tigaBulan[$i]['name']="April";
            }elseif ($no == "05") {
                $tigaBulan[$i]['name']="Mei";
            }elseif ($no == "06") {
                $tigaBulan[$i]['name']="Juni";
            }elseif ($no == "07") {
                $tigaBulan[$i]['name']="Juli";
            }elseif ($no == "08") {
                $tigaBulan[$i]['name']="Agustus";
            }elseif ($no == "09") {
                $tigaBulan[$i]['name']="September";
            }elseif ($no == "10") {
                $tigaBulan[$i]['name']="Oktober";
            }elseif ($no == "11") {
                $tigaBulan[$i]['name']="November";
            }elseif ($no == "12") {
                $tigaBulan[$i]['name']="Desember";
            }

        }
        // return $tigaBulan;
        // $date = $date->subMonth();

        $karyawan = Karyawan::where('type','Bulanan')->get();
        foreach ($karyawan as $key) {
            $absen = DB::table('attendance')->join('activities','activities.id','=','attendance.activity_id')
                ->whereRaw("DATE_FORMAT(activities.tanggal,'%Y-%m') = '$date'")
                ->where('attendance.employee_id',$key->id)
                ->where('activities.type',"Bulanan")
                ->select('attendance.*')
                ->get();
            $key['absen'] = $absen;
        }
        // return $karyawan;
        return view('karyawan.sumGaji',['items'=>$karyawan,'tigaBulan'=>$tigaBulan,'date'=>$date]);
    }

    public function sumAbsenMingguan($date=NULL){
        if(!$date){
            $date       = Carbon::now()->endOfWeek()->format("Y-m-d");
            $dateBefore = Carbon::now()->startOfWeek()->format("Y-m-d");
        }else{
            $dateBefore = $date;
            $date       = Carbon::createFromFormat('Y-m-d', $date)->endOfWeek()->format("Y-m-d");
        }
        
        // return [$date, $dateBefore];
$listMinggu = array();
        $akhir = Kegiatan::where('type','Mingguan')->orderBy('tanggal','desc')->first();
        if($akhir){
            $begin = Carbon::createFromFormat('Y-m-d', $akhir->tanggal)->subMonths(3);
            $end = Carbon::createFromFormat('Y-m-d', $akhir->tanggal);
            $key = 0;
              // List kegiatan Mingguan
            for($i = strtotime($begin->startOfWeek()); $i<=strtotime($end->endOfWeek()); $i=strtotime("+1 week",$i)){
                $carbon[]=date('Y-m-d', $i);
                $senin = Carbon::createFromFormat('Y-m-d', date('Y-m-d', $i))->startOfWeek();
                $minggu = Carbon::createFromFormat('Y-m-d', date('Y-m-d', $i))->endOfWeek();
                for ($j=strtotime($senin); $j <= strtotime($minggu) ; $j=strtotime("+1 day",$j)) { 
                    $cari = Kegiatan::where('type','Mingguan')->where('tanggal',date('Y-m-d', $j))->get();
                    if(count($cari)){
                        // masukan tanggal yang ada ke list
                        $listMinggu[$key]['name'] = $senin->toDateString()." - ".$minggu->toDateString();
                        $listMinggu[$key]['value'] = $senin->toDateString();
                        $key++;
                        // Stop pengulangan dengan menyamakan jumlah j dengan  akhir pengulangan
                        $j=strtotime($minggu);
                    }
                }
            }
        }
        
        // return $end;
        // return $listMinggu;
        $karyawan = Karyawan::where('type','Mingguan')->get();
        foreach ($karyawan as $key) {
            $absen = DB::table('attendance')->join('activities','activities.id','=','attendance.activity_id')
            ->whereBetween('activities.tanggal', [$dateBefore, $date])
            ->where('attendance.employee_id',$key->id)
            ->select('attendance.*')
            ->get();
            $key['absen'] = $absen;
        }
        $absen = DB::table('attendance')->join('activities','activities.id','=','attendance.activity_id')
            ->whereBetween('activities.tanggal', [$dateBefore, $date])
            ->select('attendance.*')
            ->get();
        // return $absen;
        return view('karyawan.sumAbsenMingguan',['items'=>$karyawan,'date'=>$date,'listMinggu'=>$listMinggu]);
    }

    public function absenKaryawan($id){

        $tigaBulan = array();
        for($i=0;$i<3;$i++){
            $no = date('m', strtotime('-'.$i.' month'));
            $tigaBulan[$i]['id']= $no;
            $tigaBulan[$i]['m']= date('Y-m', strtotime('-'.$i.' month'));
            if($no == "01"){
                $tigaBulan[$i]['name']="Januari";
            }elseif ($no == "02") {
                $tigaBulan[$i]['name']="Februari";
            }elseif ($no == "03") {
                $tigaBulan[$i]['name']="Maret";
            }elseif ($no == "04") {
                $tigaBulan[$i]['name']="April";
            }elseif ($no == "05") {
                $tigaBulan[$i]['name']="Mei";
            }elseif ($no == "06") {
                $tigaBulan[$i]['name']="Juni";
            }elseif ($no == "07") {
                $tigaBulan[$i]['name']="Juli";
            }elseif ($no == "08") {
                $tigaBulan[$i]['name']="Agustus";
            }elseif ($no == "09") {
                $tigaBulan[$i]['name']="September";
            }elseif ($no == "10") {
                $tigaBulan[$i]['name']="Oktober";
            }elseif ($no == "11") {
                $tigaBulan[$i]['name']="November";
            }elseif ($no == "12") {
                $tigaBulan[$i]['name']="Desember";
            }
        }
        $date = Carbon::now()->format("Y-m");
        $absen = DB::table('attendance')->join('activities','activities.id','=','attendance.activity_id')
                ->whereRaw("DATE_FORMAT(activities.tanggal,'%Y-%m') = '$date'")
                ->where('attendance.employee_id',$id)
                ->select('attendance.*','activities.tanggal')
                ->addSelect('activities.tanggal')
                ->get();
        $karyawan = Karyawan::find($id);
        return view('karyawan.absenKaryawan',['karyawan'=>$karyawan,'data'=>$absen,'tigaBulan'=>$tigaBulan,'date'=>$date,'id'=>$id]);
    }

    public function absenKaryawanPost($id, Request $request){

        $tigaBulan = array();
        for($i=0;$i<3;$i++){
            $no = date('m', strtotime('-'.$i.' month'));
            $tigaBulan[$i]['id']= $no;
            $tigaBulan[$i]['m']= date('Y-m', strtotime('-'.$i.' month'));
            if($no == "01"){
                $tigaBulan[$i]['name']="Januari";
            }elseif ($no == "02") {
                $tigaBulan[$i]['name']="Februari";
            }elseif ($no == "03") {
                $tigaBulan[$i]['name']="Maret";
            }elseif ($no == "04") {
                $tigaBulan[$i]['name']="April";
            }elseif ($no == "05") {
                $tigaBulan[$i]['name']="Mei";
            }elseif ($no == "06") {
                $tigaBulan[$i]['name']="Juni";
            }elseif ($no == "07") {
                $tigaBulan[$i]['name']="Juli";
            }elseif ($no == "08") {
                $tigaBulan[$i]['name']="Agustus";
            }elseif ($no == "09") {
                $tigaBulan[$i]['name']="September";
            }elseif ($no == "10") {
                $tigaBulan[$i]['name']="Oktober";
            }elseif ($no == "11") {
                $tigaBulan[$i]['name']="November";
            }elseif ($no == "12") {
                $tigaBulan[$i]['name']="Desember";
            }
        }
        $date = date('Y').'-'.$request->input('bulan');
        $absen = DB::table('attendance')->join('activities','activities.id','=','attendance.activity_id')
                ->whereRaw("DATE_FORMAT(activities.tanggal,'%Y-%m') = '$date'")
                ->where('attendance.employee_id',$id)
                ->select('attendance.*','activities.tanggal')
                ->addSelect('activities.tanggal')
                ->get();
        $karyawan = Karyawan::find($id);
        return view('karyawan.absenKaryawan',['karyawan'=>$karyawan,'data'=>$absen,'tigaBulan'=>$tigaBulan,'date'=>$date,'id'=>$id]);
    }

    public function absenPilih() {
        $mingguan = Karyawan::where('type','Mingguan')->where('status',1)->get();
        $bulanan = Karyawan::where('type','Bulanan')->where('status',1)->get();
        return view('karyawan.absenPilih',['mingguan'=>$mingguan,'bulanan'=>$bulanan]);
    }

    public function slip($id){
        $karyawan = Gaji::with('karyawan')->find($id);
        // return $karyawan;
        $view=view('karyawan.slip1',['item'=>$karyawan]);
        $pdfq=\App::make('dompdf.wrapper');
        $pdfq->loadHtml($view)->setPaper('a5','landscape');
        return $pdfq->stream('LR-.pdf');
        return view('karyawan.slip1',['item'=>$karyawan]);
    }

    public function slipGaji($tipe=NULL,$date=NULL){
        $karyawan = Gaji::with('karyawan')->where('tanggal',$date)->where('type',$tipe)->get();
        // return $karyawan;
        $view=view('karyawan.slip',['items'=>$karyawan]);
        $pdfq=\App::make('dompdf.wrapper');
        $pdfq->loadHtml($view)->setPaper('a5','landscape');
        return $pdfq->stream('LR-.pdf');
        return view('karyawan.slip1',['items'=>$karyawan]);
    }

    public function excelGajiShow($tipe,$date){
        $items = $this->getGajiShow($tipe,$date);

        Excel::create('Gaji '.$tipe.'-'.$date, function($excel) use($items) {

            $excel->sheet('1', function($sheet) use($items) {
                $sheet->loadView('excel.gajiShow',['items'=>$items]);
            });
        })->download('xls');
    }

    public function cekTanggalAbsen($date){
      $cari = Kegiatan::where('tanggal',$date)->select('tanggal')->get();
      if(count($cari)){
          $respon = [
              "warning" => "<span class='text-red'>Opss! Anda sudah mengisi absen pada tanggal tersebut.</span>",
              "status"  => true
          ];
      }else{
          $respon = [
              "warning" => "<span class='text-green'>Silahkan absen. Tanggal tersedia..</span>",
              "status"  => false
          ];

      }
      return $respon;
    }
    public function generateGaji(){
      $awal = Kegiatan::where('status',0)->orderBy('tanggal','asc')->first();
      $akhir = Kegiatan::where('status',0)->orderBy('tanggal','desc')->first();
      $listMinggu = null;
      $listBulan = null;
      if($awal && $akhir){
        $begin = Carbon::createFromFormat('Y-m-d', $awal->tanggal);
        $end = Carbon::createFromFormat('Y-m-d', $akhir->tanggal);
        $carbon = array();
          $listMinggu = array();
          $listBulan = array();
          $key = 0;
          // List kegiatan Mingguan
          for($i = strtotime($begin->startOfWeek()); $i<=strtotime($end->endOfWeek()); $i=strtotime("+1 week",$i)){
            $carbon[]=date('Y-m-d', $i);
            $senin = Carbon::createFromFormat('Y-m-d', date('Y-m-d', $i))->startOfWeek();
            $minggu = Carbon::createFromFormat('Y-m-d', date('Y-m-d', $i))->endOfWeek();
            for ($j=strtotime($senin); $j <= strtotime($minggu) ; $j=strtotime("+1 day",$j)) { 
                $cari = Kegiatan::where('status',0)->where('type','Mingguan')->where('tanggal',date('Y-m-d', $j))->get();
                if(count($cari)){
                    // masukan tanggal yang ada ke list
                    $listMinggu[$key]['name'] = $senin->toDateString()." - ".$minggu->toDateString();
                    $listMinggu[$key]['value'] = $senin->toDateString();
                    $key++;
                    // Stop pengulangan dengan menyamakan jumlah j dengan  akhir pengulangan
                    $j=strtotime($minggu);
                }
            }
          }
          // list kegiata bulanan
          $key = 0;
          for($i = strtotime($begin->startOfMonth()); $i<=strtotime($end->endOfMonth()); $i=strtotime("+1 month",$i)){
            $carbon[]=date('Y-m-d', $i);
            $awalBulan = Carbon::createFromFormat('Y-m-d', date('Y-m-d', $i))->startOfMonth();
            $akhirBulan = Carbon::createFromFormat('Y-m-d', date('Y-m-d', $i))->endOfMonth();
            for ($j=strtotime($awalBulan); $j <= strtotime($akhirBulan) ; $j=strtotime("+1 day",$j)) { 
                $cari = Kegiatan::where('status',0)->where('type','Bulanan')->where('tanggal',date('Y-m-d', $j))->get();
                if(count($cari)){
                    // masukan tanggal yang ada ke list
                    $listBulan[$key]['name'] = $awalBulan->format('F');
                    $listBulan[$key]['value'] = $awalBulan->toDateString();
                    $key++;
                    // Stop pengulangan dengan menyamakan jumlah j dengan  akhir pengulangan
                    $j=strtotime($akhirBulan);
                }
            }
          }
          return view('karyawan.rekapGaji',['listBulan'=>$listBulan,'listMinggu'=>$listMinggu]);
      }else{
            return view('karyawan.rekapGaji',['listBulan'=>$listBulan,'listMinggu'=>$listMinggu]);
      }
      
      
    }

    public function rekapGajiStrore(Request $request){
        // Gaji Bulanan
        // $date = date("Y-m");
        if($request->input('tipe')=="Bulanan"){
            $date = Carbon::createFromFormat('Y-m-d', $request->input('bulan'));
            $date = $date->format("Y-m");
            $transaction = Transactions::with('account')->whereRaw("DATE_FORMAT(transaction_date,'%Y-%m') = '$date'")->where('name','like','Kasbon%')->get();
            // return $transaction;

            $karyawan = Karyawan::where('type','Bulanan')->get();

            // ambil data kegiatan untuk di convert menjadi sudah di generate
            $kegiatan = Kegiatan::where('type','Bulanan')->whereRaw("DATE_FORMAT(activities.tanggal,'%Y-%m') = '$date'")->get();

            foreach ($karyawan as $key) {
                $absen = DB::table('attendance')->join('activities','activities.id','=','attendance.activity_id')
                    ->whereRaw("DATE_FORMAT(activities.tanggal,'%Y-%m') = '$date'")
                    ->where('attendance.employee_id',$key->id)
                    // ->where('activities.status',0)
                    ->select('attendance.*')
                    ->get();
                $key['absen'] = $absen;
                $tran = array();
                if($transaction){
                    foreach ($transaction as $key2) {
                        # code...

                        $note = json_decode($key2->notes, true);
                        if($note['employee_id'] == $key->id){
                            $tran[] = $key2;
                        }
                    }

                    $key['tran']=$tran;
                }

                // return $absen;

                
            }
        }elseif($request->input('tipe')=="Mingguan"){
            $date = Carbon::createFromFormat('Y-m-d',$request->input('minggu'))->endOfWeek();
            $dateBefore = Carbon::createFromFormat('Y-m-d',$request->input('minggu'))->startOfWeek();
            $datefull = $date->toDateString();
            $date = $date->format("Y-m-d");
            $dateBefore = $dateBefore->format("Y-m-d");
            
            $transaction = Transactions::with('account')
            ->whereBetween('transaction_date', [$dateBefore, $date])
            ->where('name','like','Kasbon%')->get();
            // return $transaction;

            $karyawan = Karyawan::where('type','Mingguan')->get();

             // ambil data kegiatan untuk di convert menjadi sudah di generate
            $kegiatan = Kegiatan::where('type','Mingguan')->whereBetween('tanggal', [$dateBefore, $date])->get();

            foreach ($karyawan as $key) {
                $absen = DB::table('attendance')->join('activities','activities.id','=','attendance.activity_id')
                ->whereBetween('activities.tanggal', [$dateBefore, $date])
                    ->where('attendance.employee_id',$key->id)
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
            }
        }
        // Ganti status Activities menjadi sudah digenerate
        foreach ($kegiatan as $key => $value) {
            $activities = Kegiatan::find($value->id);
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
            $setengah = 0;
            $uang_lembur = 0;
            $uang_makan_lembur =0;
            $makan = 0;
            // Hitung jumlah absen dan lembur
            foreach ($kar->absen as $absen) {
                if($absen->status == "Tidak"){
                    $tidak++;
                }elseif ($absen->status == "Lembur") {
                    if($absen->notes){
                        $note = json_decode($absen->notes, true);
                        if($note['tipe_lembur']==1){
                            # jam 18.00
                            $uang_lembur+=4000;
                        }elseif ($note['tipe_lembur']==2) {
                            # jam 19.00
                            $uang_lembur+=9000;
                        }elseif ($note['tipe_lembur']==3) {
                            # jam 20.00
                            $uang_lembur+=14000;
                            $uang_makan_lembur+=10000;
                        }elseif ($note['tipe_lembur']==4) {
                            # jam 21.00
                            $uang_lembur+=19000;
                            $uang_makan_lembur+=10000;
                        }elseif ($note['tipe_lembur']==5) {
                            # jam 22.00
                            $uang_lembur+=24000;
                            $uang_makan_lembur+=10000;
                        }elseif ($note['tipe_lembur']==6) {
                            # jam 23.00
                            $uang_lembur+=29000;
                            $uang_makan_lembur+=10000;
                        }elseif ($note['tipe_lembur']==7) {
                            # jam 24.00
                            $uang_lembur+=34000;
                            $uang_makan_lembur+=10000;
                        }
                    }
                    
                    $lembur++;
                    $hadir++;
                }elseif ($absen->status == "Hadir") {
                    $hadir++;
                }elseif($absen->status == "Setengah Hari"){
                    $setengah++;
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
            if($request->input('tipe')=="Bulanan"){
                $gaji->tanggal     = $request->input('bulan');
                $gaji->type        = "Bulanan";
            }elseif ($request->input('tipe')=="Mingguan") {
                $gaji->tanggal     = $dateBefore;
                $gaji->type        = "Mingguan";
            }
            
            $gaji->employee_id     = $kar->id;
            $gaji->gaji_pokok      = $kar->gaji_pokok;
            $gaji->upah_lembur     = $uang_lembur;
            $gaji->uang_makan      = $uang_makan_lembur;
            $gaji->potongan_absen  = ($kar->potongan_absen*$tidak)+(($setengah*$kar->potongan_absen)*0.5);
            $gaji->potongan_kasbon = $kasbon;
            $gaji->total_gaji      = ($kar->gaji_pokok+$uang_lembur+$uang_makan_lembur-($tidak*$kar->potongan_absen)-(($setengah*$kar->potongan_absen)*0.5)-$kasbon);
            $i++;
            $gaji->save();
            // Akumulasi
            $total_gaji_pokok       += $kar->gaji_pokok;
            $total_upah_lembur      += $uang_lembur;
            $total_uang_makan       += $uang_makan_lembur;
            $total_potongan_absen   += ($kar->potongan_absen*$tidak)+(($setengah*$kar->potongan_absen)*0.5);
            $total_potongan_kasbon  += $kasbon;
            $total_gaji_keseluruhan += ($kar->gaji_pokok+$uang_lembur+$uang_makan_lembur-($tidak*$kar->potongan_absen)-(($setengah*$kar->potongan_absen)*0.5)-$kasbon);
        }

        $transaction                   = new Transactions();
        $transaction->name             = "Penggajian ".$date;
        $transaction->transaction_code = Transactions::getSysCode();
        $transaction->transaction_date = date("Y-m-d");
        if($request->input('tipe')=="Bulanan"){
            $transaction->notes      = json_encode([
                                            'salary_date'=> $request->input('bulan'),
                                            'type'  => 'Bulanan'
                                            ]); 
        }elseif ($request->input('tipe')=="Mingguan") {
            $transaction->notes     =  json_encode(['salary_date'=> $dateBefore, 'type'  => 'Mingguan']);
        }
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

        return redirect()->to(url('gaji'))->with('hijau','Berhasil Merekap Gaji');
    }

    public function salaryDestroy(Request $request){
        $jenis = $request->input('jenis');
        // Hapus data gaji
        $gaji = Gaji::where('tanggal',$request->input('tanggal'))->where('type',$jenis)->delete();
        // rubah kegiatan kembali ke status belum ke generate
        if($jenis == "Bulanan"){
            $tanggal = date('Y-m',strtotime($request->input('tanggal')));
            DB::table('activities')->whereRaw("DATE_FORMAT(tanggal,'%Y-%m') = '$tanggal'")
            ->where('type',$jenis)
            ->update(['status'=>0]);
        }elseif ($jenis == "Mingguan") {
            $dateBefore = Carbon::createFromFormat('Y-m-d',$request->input('tanggal'))->startOfWeek()->format("Y-m-d");
            $dateAfter =  Carbon::createFromFormat('Y-m-d',$request->input('tanggal'))->endOfWeek()->format("Y-m-d");
            DB::table('activities')->whereBetween('tanggal',[$dateBefore,$dateAfter])
            ->where('type',$jenis)
            ->update(['status'=>0]);
        }
        
        // Hapus transaksi gaji
            $transactions = Transactions::where('notes','like','%'.$request->input('tanggal').'%')
                            ->where('notes','like','%'.$request->input('jenis').'%')->delete();
        return redirect()->back()->with('hijau','Berhasil dihapus');
    }

    public function aktifKaryawan($id){
        $item = Karyawan::find($id);
        $item->status = 1;
        $item->save();

        return redirect()->back()->with('hijau','Berhasil mengaktifkan karyawan');
    }

    public function nonAktifKaryawan($id){
        $item = Karyawan::find($id);
        $item->status = 0;
        $item->save();

        return redirect()->back()->with('hijau','Berhasil menonaktifkan karyawan');
    }


}
