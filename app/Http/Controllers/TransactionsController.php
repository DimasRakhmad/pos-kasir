<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Transactions;
use App\Models\TransactionDetails;
use App\Models\Accounts;
use App\Models\Giro;
use App\Models\Barang;
use App\Models\TutupBuku;
use App\Models\Gudang;
use App\Models\Tank;
use App\Models\Partner;
use Excel;

use DB;

class TransactionsController extends Controller
{
    public function getRaw($tipe){
        if($tipe == 'penjualan')
            $where = 'amount_out';
        elseif($tipe == 'pembelian')
            $where = 'amount_in';
        // return Transactions::with(['transactionDetails'=>function ($query){
        //     $query->whereNotNull('item_id');
        // }])->with('transactionDetails.barang')
        // ->with('transactionDetails.gudang')->with('partner')->get();
        return DB::table('items')->join('transaction_details','transaction_details.item_id','=','items.id')
                ->join('transactions','transactions.id','=','transaction_details.transaction_id')
                ->join('partner','partner.id','=','transactions.partner_id')
                ->join('stocks','stocks.transaction_detail_id','=','transaction_details.id')
                // ->join('items','items.id','=','transaction_details.item_id')
                // ->where('transaction_details.amount','>=',0)
                // ->whereRaw("DATE_FORMAT(transactions.transaction_date,'%Y-%m') = '$tanggal'")
                // ->groupBy('items.id')
                // ->selectRaw('items.name, sum(stocks.price) as jumlah')
                ->whereNotNull('stocks.'.$where)
                ->select('transactions.transaction_date','transactions.transaction_code','partner.name','items.name as barang','stocks.'.$where.' as amount','stocks.unit_price','stocks.price')
                ->orderBy('transactions.id')
                ->orderBy('transactions.transaction_date')
                ->get();
    }
    // Function ambil data penjualan
    public function getPenjualan($tanggal){
        return DB::table('items')->join('transaction_details','transaction_details.item_id','=','items.id')
                ->join('transactions','transactions.id','=','transaction_details.transaction_id')
                ->join('stocks','stocks.transaction_detail_id','=','transaction_details.id')
                ->where('transaction_details.amount','>=',0)
                ->whereRaw("DATE_FORMAT(transactions.transaction_date,'%Y-%m') = '$tanggal'")
                ->groupBy('items.id')
                ->selectRaw('items.name, sum(stocks.price) as jumlah')
                ->get();
    }

    public function getPembelian($tanggal){
        return DB::table('items')->join('transaction_details','transaction_details.item_id','=','items.id')
                ->join('transactions','transactions.id','=','transaction_details.transaction_id')
                ->join('stocks','stocks.transaction_detail_id','=','transaction_details.id')
                ->where('transaction_details.amount','<',0)
                ->whereRaw("DATE_FORMAT(transactions.transaction_date,'%Y-%m') = '$tanggal'")
                ->groupBy('items.id')
                ->selectRaw('items.name, sum(stocks.price) as jumlah')
                ->get();
    }

    public function getIndexKas(){
        return Accounts::with('transaction')->with('transaction.transactionDetails.barang')->with('transaction.transactionDetails.gudang')->find(1);
    }

    public function getIndexKasTangki(){
        return Accounts::with('transaction')->find(3);
    }

    public function getTransaksi($begin,$end){
        return DB::table('transactions')
            ->join('transaction_details','transaction_details.transaction_id','=','transactions.id')
            ->join('stocks','stocks.transaction_detail_id','=','transaction_details.id')
            ->join('items','items.id','=','stocks.item_id')
            ->groupBy('transactions.id')
            ->whereBetween('transactions.transaction_date',[$begin,$end])
            ->select('transactions.id', 'transactions.name', 'transactions.transaction_code', 'transactions.transaction_date')
            ->get();
        // return Transactions::with('account')->whereBetween('transaction_date',[$begin,$end])->get();
    }

    public function getTransaksiByCode($code){
        return DB::table('transactions')
            ->join('transaction_details','transaction_details.transaction_id','=','transactions.id')
            ->join('stocks','stocks.transaction_detail_id','=','transaction_details.id')
            ->join('items','items.id','=','stocks.item_id')
            ->groupBy('transactions.id')
            ->where('transactions.transaction_code','like','%'.$code.'%')
            ->select('transactions.id', 'transactions.name', 'transactions.transaction_code', 'transactions.transaction_date')
            ->get();
        // return Transactions::with('account')->whereBetween('transaction_date',[$begin,$end])->get();
    }

    public function getShowTransaction($id){
        // return DB::table('transactions')
        //     ->join('transaction_details','transaction_details.transaction_id','=','transactions.id')
        //     ->join('stocks','stocks.transaction_detail_id','=','transaction_details.id')
        //     ->join('items','items.id','=','stocks.item_id')
        //     ->where('transactions.id',$id)
        //     ->select('*')
        //     // ->select('transactions.id', 'transactions.name', 'transactions.transaction_code', 'transactions.transaction_date')
        //     ->get();
        $items = Transactions::with('transactionDetails')->find($id);
        foreach ($items->transactionDetails as $key => $value) {
            # code...
            $barang = Gudang::where('transaction_detail_id',$value->id)->get();
            if(count($barang)){
                $items->transactionDetails[$key]['gudang'] = $barang;
            }else{
                $items['pembayaran'] = $items->transactionDetails[$key];
                unset($items->transactionDetails[$key]);
            }


        }
        return $items;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create-jurnal');
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
        $detail = $request->input('detail');
        $transaction = new Transactions();
        $transaction->transaction_code = $request->input('transaction_code');
        $transaction->name = $request->input('name');
        $transaction->notes = $request->input('notes');
        $transaction->transaction_date = $request->input('date');
        if($transaction->save()){
            foreach ($detail as $key ) {
                if ($key['debit'] != ''){
                    $amount = $key['debit'];
                }else {
                    $amount = $key['kredit']*-1;
                }
                $transaction->account()->attach(['account_id'=>$key['selectedAccount']['id']],['amount'=>$amount]);
            }
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
        $detail      = $request->input('detail');
        $transaction = Transactions::find($id);
        $transaction->transaction_code = $request->input('transaction_code');
        $transaction->name = $request->input('name');
        $transaction->notes = $request->input('notes');
        $transaction->transaction_date = $request->input('date');
        if($transaction->save()){
            $transaction->account()->detach();
            foreach ($detail as $key ) {
                if ($key['debitAmount'] != ''){
                    $amount = $key['debitAmount'];
                }else {
                    $amount = $key['creditAmount']*-1;
                }
                $transaction->account()->attach(['account_id'=>$key['account_id']],['amount'=>$amount]);
            }
            return "berhasil";
        }
        else {
            return "gagal";
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
        Transactions::destroy($id);
        return redirect()->back()->with('hijau','Transaksi berhasil dihapus');
    }

    public function indexGiro(){
        $items = Giro::with('bank')->where('status',1)->get();
        return view('laporan.giro',['items'=>$items]);
    }

    public function bilyetGiro($id){
        $giro = Giro::find($id);
        $banks = Bank::all();
        return view('payment.bilyetGiro',['giro'=>$giro,'banks'=>$banks]);
    }

    public function storeBilyetGiro($id, Request $request){
        $giro = Giro::find($id);
        $bank = Bank::find($request->input('bank'));
        $transaction                   = new Transactions();
        $transaction->transaction_code = Transactions::getSysCodeGiro();
        $transaction->transaction_date = date("Y-m-d");
        $transaction->save();
        // kredit giro
        $tran                 = new TransactionDetails();
        $tran->transaction_id = $transaction->id;
        $tran->account_id     = 2;
        $tran->amount         = -1*$giro->nominal;
        $tran->save();
        // Debit Bank
        $tran                 = new TransactionDetails();
        $tran->transaction_id = $transaction->id;
        $tran->account_id     = $bank->account_id;
        $tran->amount         = $giro->nominal;
        $tran->save();

        //Hapus giro
        $giro->delete();

        return redirect()->to(url('daftarGiro'));
    }

    public function indexKas(){
        $items = $this->getIndexKas();
        return view('laporan.mutasiKas',['items'=>$items]);
    }

    public function indexKasTangki(){
        $items = $this->getIndexKasTangki();
        // return $account;
        return view('laporan.mutasiKas',['items'=>$items]);
    }

    public function detailTransaksi($id){
        $items = Transactions::with('transactionDetails')->with('transactionDetails.barang')->with('transactionDetails.gudang')->find($id);
        return $items;
        return view('laporan.detailTransaksi',['items'=>$items]);
    }

    public function transfer(){
        // return Transactions::getCode('TD');
        $akun = Accounts::with('accountGroup')->with('transaction')->with('bank')->where('group_id',6)->Where('id','!=',2)->orWhere('group_id',10)->get();
        return view('payment.transfer',['items'=>$akun]);
    }

    public function postTransfer(Request $request){
        $dari = Accounts::find($request->input('dari'));
        $ke = Accounts::find($request->input('ke'));
        $transaction                   = new Transactions();
        $transaction->transaction_code = Transactions::getCode('TD');
        $transaction->name             = "Pemindahan dari ".$dari->name." ke ".$ke->name;
        $transaction->transaction_date = date("Y-m-d");
        $transaction->save();
        // kredit sumber
        $tran                 = new TransactionDetails();
        $tran->transaction_id = $transaction->id;
        $tran->account_id     = $dari->id;
        $tran->amount         = -1*$request->input('jumlah');
        $tran->save();
        // Debit tujuan
        $tran                 = new TransactionDetails();
        $tran->transaction_id = $transaction->id;
        $tran->account_id     = $ke->id;
        $tran->amount         = $request->input('jumlah');
        $tran->save();

        return redirect()->route('bank.index')->with('hijau','Pemindahan dana berhasil');
    }

    public function penjualan($date=NULL){

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

        if($date==NULL){
            $tanggal = date('Y-m');
        }else{
            $tanggal = date('Y').'-'.$date;
        }

        $items = $this->getPenjualan($tanggal);

        return view('gudang.penjualan',['items'=>$items,'tigaBulan'=>$tigaBulan,'date'=>$tanggal]);
    }

    public function pembelian($date=NULL){

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

        if($date==NULL){
            $tanggal = date('Y-m');
        }else{
            $tanggal = date('Y').'-'.$date;
        }

        $items = $this->getPembelian($tanggal);

        return view('gudang.pembelian',['items'=>$items,'tigaBulan'=>$tigaBulan,'date'=>$tanggal]);
    }

    public function exportPenjualan($date=NULL){

        if($date==NULL){
            $tanggal = date('Y-m');
        }else{
            $tanggal = $date;
        }

        $items = $this->getPenjualan($tanggal);

        Excel::create('Pembelian '.$tanggal, function($excel) use($items) {

            $excel->sheet('1', function($sheet) use($items) {
                $sheet->loadView('gudang.excel',['items'=>$items]);
            });
        })->download('xls');
    }

    public function exportPembelian($date=NULL){

        if($date==NULL){
            $tanggal = date('Y-m');
        }else{
            $tanggal = $date;
        }

        $items = $this->getPembelian($tanggal);

        Excel::create('Pembelian '.$tanggal, function($excel) use($items) {

            $excel->sheet('1', function($sheet) use($items) {
                $sheet->loadView('gudang.excel',['items'=>$items]);
            });
        })->download('xls');
    }

    public function excelIndexKas(){

        $items = $this->getIndexKas();

        Excel::create('Index Kas', function($excel) use($items) {

            $excel->sheet('1', function($sheet) use($items) {
                $sheet->loadView('excel.indexKas',['items'=>$items]);
            });
        })->download('xls');
    }

    public function excelIndexKasTangki(){

        $items = $this->getIndexKasTangki();

        Excel::create('Index Kas Tangki ', function($excel) use($items) {

            $excel->sheet('1', function($sheet) use($items) {
                $sheet->loadView('excel.indexKasTangki',['items'=>$items]);
            });
        })->download('xls');
    }

    public function rawPenjualan(){
        $items = $this->getRaw('penjualan');
        // return view('excel.rawPenjualan',['items'=>$items]);
        Excel::create('Raw Penjualan '.date('Y-m-d'), function($excel) use($items) {

            $excel->sheet('1', function($sheet) use($items) {
                $sheet->loadView('excel.rawPenjualan',['items'=>$items]);
            });
        })->download('xls');
    }

    public function rawPembelian(){
        $items = $this->getRaw('pembelian');
        // return view('excel.rawPenjualan',['items'=>$items]);
        Excel::create('Raw Pembelian '.date('Y-m-d'), function($excel) use($items) {

            $excel->sheet('1', function($sheet) use($items) {
                $sheet->loadView('excel.rawPembelian',['items'=>$items]);
            });
        })->download('xls');
    }

    public function tutupBuku(){
        $tutupBuku = TutupBuku::orderBy('tanggal','desc')->first();
        if($tutupBuku){
            // return $tutupBuku;
            return view('tutupBuku',['dari'=>$tutupBuku->tanggal]);
        }else{
            $trans = Transactions::orderBy('transaction_date','asc')->first();
            return view('tutupBuku',['dari'=>$trans->transaction_date]);
        }


    }

    public function tutupBukuPost(Request $request){

        $dari = $request->input('dari');
        $sampai = date("Y-m-d", strtotime($request->input('sampai')));

        $akun = Accounts::with(['transaction'=>function($query)use($dari,$sampai){
            $query->whereBetween('transactions.transaction_date',[$dari,$sampai]);
        }])->get();
        foreach ($akun as $key => $value) {
            // Deklarasi variable
            $saldo = 0;
            foreach ($value->transaction as $key2 => $value2) {
                $saldo += $value2->pivot->amount;
            }
            // $akun[$key]['saldo'] =$saldo;
            $tutup = new TutupBuku();
            $tutup->tanggal = $sampai;
            $tutup->account_id = $value->id;
            $tutup->saldo = $saldo;
            $tutup->save();
        }
        // $akun = Accounts::all();
        // foreach ($akun as $key => $value) {
        //     # code...
        //     $transaction = DB::table('transactions')
        //                     ->join('transaction_details','transactions.id','=','transaction_details.transaction_id')
        //                     ->whereBetween('transactions.transaction_date',[$dari,$sampai])
        //                     ->where('transaction_details.account_id',$value->id)
        //                     ->select('amount')
        //                     ->get();
        //     $akun[$key]['transaction'] = $transaction;
        // }
        return redirect()->back()->with('hijau','Tutup buku berhasil..');
    }
    /**
     * Daftar transaksi
     * 
     */
    public function daftarTransaksi($begin=NULL, $end=NULL){
        if(!$begin && !$end){
            $begin = date('Y-m-d');
            $end = date('Y-m-d');
        }
        $items = $this->getTransaksi($begin,$end);
        // return $items;
        return view('daftar-transaksi',['items'=>$items,'begin'=>$begin,'end'=>$end,'tipe'=>'tanggal','code'=>'']);
    }

    public function searchByCode($code){
        // $code = $request->input('code');
        $items = $this->getTransaksiByCode($code);
        // if(!$begin && !$end){
            $begin = date('Y-m-d');
            $end = date('Y-m-d');
        // }

        return view('daftar-transaksi',['items'=>$items,'tipe'=>'kode','code'=>$code]);
    }

    public function edit($id)
    {
        //
        // $items = Transactions::with('transactionDetails')->with('transactionDetails.gudang')->find($id);

        $items = $this->getShowTransaction($id);
        if(substr($items->name,0,9)=="Penjualan"){
            $tipe = "Keluar";
            $customer = Partner::where('type','Customer')->get();
        }elseif(substr($items->name,0,9)=="Pembelian"){
            $tipe = "Masuk";
            $customer = Partner::where('type','Supplier')->get();
        }


        $barang   = Barang::all();
        $tank     = Tank::where('stock','!=',2)->get();

        $giro     = Giro::with('bank')->where('status',1)->get();
        $types  = Bank::all();

        // return $items;
        return view('edit-transaksi',['items'=>$items,'tipe'=>$tipe,'barang'=>$barang,'tank'=>$tank,'customer'=>$customer,'giro'=>$giro,'types'=>$types]);
    }

    public function updateTransaksi($id,Request $request){
        // Pengambilan data
        // return $request->all();
        $id_barang        = $request->input('id_barang');
        $jumlah           = $request->input('jumlah');
        $harga            = $request->input('harga');
        $id_tank          = $request->input('id_tank');
        $tipeA            = $request->input('tipeA');
        $date             = $request->input('tanggal');
        $tipe_bayar       = $request->input('bayar');
        $total            = 0;
        $tipe             = $request->input('type');
        $detail_transaksi = $request->input('transaction_details_id');
        $gudang_id        = $request->input('gudang_id');
        $pembayaran       = $request->input('pembayaran');

        // Cari partner transaksi
        $partner     = Partner::find($request->input('partner_id'));
        // Hapus Transaksi
        Transactions::destroy($id);
        // Buat transaksi baru
        $transaction = new Transactions();
        // Cek jensi transaksi
        if($request->input('tipe')=="Keluar"){
            $transaction->name = "Penjualan ke ".$partner->company." [".$date."]";
        }elseif ($request->input('tipe')=="Masuk") {
            $transaction->name = "Pembelian ke ".$partner->company." [".$date."]";
        }

        // set belum dibayar
        if($tipe_bayar == 0){
            $transaction->status = -1;
        }

        $transaction->transaction_code = $request->input('no_resi');
        $transaction->partner_id       = $request->input('partner_id');
        $transaction->transaction_date = date("Y-m-d", strtotime($date));
        $transaction->save();


        // Input data detail transaksi
       foreach ($id_barang as $key => $value) {
            $barang               = Barang::find($id_barang[$key]);
            $tran   = new TransactionDetails();
            $gudang = new Gudang();
            $tran->transaction_id = $transaction->id;
            $amount               = $harga[$key] * $jumlah[$key];
            $gudang->item_id      = $id_barang[$key];
            if($tipeA[$key]=='Keluar'){
                $tran->account_id = $barang->sale_account_id;
                $tran->amount = -1*$amount;
                $gudang->amount_out = $jumlah[$key];
            }elseif ($tipeA[$key]=='Masuk'){
                $tran->account_id = $barang->purchase_account_id;
                $tran->amount = $amount;
                $gudang->amount_in = $jumlah[$key];
            }
            if($id_tank[$key]){
                $gudang->tank_id = $id_tank[$key];
            }
            $gudang->partner_id     = $request->input('partner_id');
            $gudang->unit_price     = $harga[$key];
            $gudang->price          = $amount;
            $gudang->type           = $tipeA[$key];
            $tran->item_id          = $id_barang[$key];
            $tran->save();
            $gudang->transaction_detail_id = $tran->id;
            $gudang->save();
            $total+=$amount;
       }
       // Simpan akun pembayaran
       if($tipe_bayar == 0){
        // tidak tunai
           $tran =  new TransactionDetails();
           $tran->transaction_id = $transaction->id;
           if($request->input('tipe')=="Keluar"){
                $tran->amount         = $total;
           }elseif ($request->input('tipe')=="Masuk") {
                $tran->amount         = -1*$total;
           }
           $tran->account_id     = $partner->account_id;
           $tran->save();
       }elseif ($tipe_bayar == 1 && $request->input('tipe')=="Keluar") {
        // Tunai
               if($tipe == "tunai"){
                // kredit akun kas (1)
                $tran2                 = new TransactionDetails();
                $tran2->transaction_id = $transaction->id;
                $tran2->account_id     = 1;
                $tran2->amount         = $total;
                $tran2->save();
            }elseif ($tipe=="transfer") {
                // kredit akun bank
                $payment = Bank::find($request->input('bank'));
                $tran2                 = new TransactionDetails();
                $tran2->transaction_id = $transaction->id;
                $tran2->account_id     = $payment->account_id;
                $tran2->amount         = $total;
                $tran2->save();
            }
       }elseif ($tipe_bayar == 1 && $request->input('tipe')=="Masuk") {
               if($tipe == "tunai"){
                // kredit akun kas (1)
                $tran2                 = new TransactionDetails();
                $tran2->transaction_id = $transaction->id;
                $tran2->account_id     = 1;
                $tran2->amount         = -1*$total;
                $tran2->save();
            }elseif ($tipe=="transfer") {
                // kredit akun bank
                $payment = Bank::find($request->input('bank'));
                $tran2                 = new TransactionDetails();
                $tran2->transaction_id = $transaction->id;
                $tran2->account_id     = $payment->account_id;
                $tran2->amount         = -1*$total;
                $tran2->save();
            }
       }

       return redirect()->to(url('daftar-transaksi'))->with('hijau','Transaksi '.$transaction->name.' berhasil diperbaharui..');
    }
    /**
     * Cek nomor resi
     * 
     */
    public function cekNoResi($no_resi){
        /*
        Cari nomor resi
         */
        $cari = Transactions::where('code',$no_resi)->select('code')->get();
        if(count($cari)){
            $respon = [
                "warning" => "<span class='text-red'>Opss! Nomor resi sudah terpakai.</span>",
                "status"  => true
            ];
        }else{
            $respon = [
                "warning" => "<span class='text-green'>Nomor resi tersedia</span>",
                "status"  => false
            ];
        }
        return $respon;

    }

    public function penyesuaianDana(){
        $akun = Accounts::with('accountGroup')->with('transaction')->with('bank')->where('group_id',6)->Where('id','!=',2)->orWhere('group_id',10)->get();
        // return $akun;
        return view('penyesuaianDana',['akun'=>$akun]);
    }

    public function penyesuaianDanaStore(Request $request){
        $akun = Accounts::find($request->input('akun'));

        $transaction = new Transactions();
        $transaction->name = "Penyesuian (".$request->input('keterangan').")";
        if($request->input('tipe')=="kredit"){
            $amount = -1*$request->input('amount');
        }elseif ($request->input('tipe')=="debit") {
            $amount = $request->input('amount');
        }
        $transaction->transaction_code = $request->input('no_resi');
        $transaction->transaction_date = date("Y-m-d", strtotime($request->input('tanggal')));
        $transaction->save();

        $transactionDetails                 = new TransactionDetails();
        $transactionDetails->transaction_id = $transaction->id;
        $transactionDetails->account_id     = $request->input('akun');
        $transactionDetails->amount         = $amount;
        $transactionDetails->save();

        return redirect()->route('bank.index')->with('hijau','Penyesuaian Dana Berhasil');
    }

}
