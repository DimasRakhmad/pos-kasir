<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\Tank;
use App\Models\Partner;
use App\Models\Transactions;
use App\Models\Giro;
use App\Models\Bank;
use App\Models\TransactionDetails;
use Excel;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndexGudang(){
      return Gudang::with('barang')->groupBy('item_id')->selectRaw('*, sum(amount_in) as sum_in, sum(amount_out) as sum_out')->get();
    }

    public function index()
    {
        //
        $gudang = $this->getIndexGudang();
        // return $gudang;
        return view('gudang.index',['gudang'=>$gudang]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $barang = Barang::all();
        $tank = Tank::where('stock','!=',2)->get();
        $giro     = Giro::with('bank')->where('status',1)->get();
        $types  = Bank::all();
        $customer = Partner::where('type','Supplier')->get();
        return view('gudang.createMasuk',['barang'=>$barang,'tank'=>$tank,'customer'=>$customer,'giro'=>$giro,'types'=>$types]);
    }

    public function createKeluar()
    {
        //
        $barang   = Barang::all();
        $tank     = Tank::where('stock','!=',2)->get();
        $customer = Partner::where('type','Customer')->get();
        $giro     = Giro::with('bank')->where('status',1)->get();
        $types  = Bank::all();
        return view('gudang.createKeluar',['barang'=>$barang,'tank'=>$tank,'customer'=>$customer,'giro'=>$giro,'types'=>$types]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //status bayar 1 = tunai 0 = hutang
      // return $request->all();
        $date                          = $request->input('tanggal');
        $tipe_bayar = $request->input('bayar');
        $total = 0;
        $partner              = Partner::find($request->input('partner_id'));
        
        $transaction                   = new Transactions();
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
        $id_barang = $request->input('id_barang');
        $jumlah = $request->input('jumlah');
        $harga = $request->input('harga');
        $id_tank = $request->input('id_tank');
        $tipeA = $request->input('tipeA');

        $tipe = $request->input('type');
       foreach ($id_barang as $key => $value) {
            $barang               = Barang::find($id_barang[$key]);
            $tran                 = new TransactionDetails();
            $tran->transaction_id = $transaction->id;
            $amount               = $harga[$key] * $jumlah[$key];
            $gudang               = new Gudang();
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
       // tidak tunai
       if($tipe_bayar == 0){

           $tran                 = new TransactionDetails();
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
       if($request->input('tipe')=="Keluar"){
                // Mulai proses untuk print
          // $data2 = $request->input('id)');
         // return "done";
          $new = array();
          foreach ($id_barang as $key => $value) {
            $detail_barang = Barang::find($value);
            $new[$key]['detail_barang'] = $detail_barang;
            $new[$key]['jumlah'] = $jumlah[$key];
            $new[$key]['harga'] = $harga[$key];
          }
          $pt = Partner::find($request->input('partner_id'));
          $no_resi = $request->input('no_resi');
          
          // return $new;
          return view('gudang.faktur',['data'=>$new,'no_resi'=>$no_resi,'tanggal'=>date("Y-m-d", strtotime($date)),'partner'=>$pt]);

          // Akhir proses print
        }elseif ($request->input('tipe')=="Masuk") {
            return redirect()->route('gudang.index')->with('hijau','Penambahan data gudang berhasil.');
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
        // $barang = Barang::all();
        // $tank = Tank::all();
      // Ambil data gudang
        $gudang = Gudang::with('barang')->find($id);
      // Ambil data transaction detail

        $td = TransactionDetails::find($gudang->transaction_detail_id);
        if($td){
          // jika transaction detail ditemukan, redirect ke edit transaction sesuai dengan transaction ID
          return redirect()->route('transactions.edit',$td->transaction_id);
        }else{
          return redirect()->back()->with('merah','Maaf, riwayat transaksi tersebut tidak bisa di ubah');
        }
        
        // return [$gudang,$td];
        // return view('gudang.edit',['gudang'=>$gudang,'barang'=>$barang,'tank'=>$tank]);
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
        $gudang = Gudang::find($id);
        $gudang->item_id = $request->input('id_barang');
        if($request->input('tipe')=='Keluar'){
            $gudang->amount_out = $request->input('jumlah');
         }elseif ($request->input('tipe')=='Masuk') {
             $gudang->amount_in = $request->input('jumlah');
        }
        if($request->input('id_tank')){
                $gudang->tank_id = $request->input('id_tank');
            }
        $gudang->unit_price  = $request->input('harga');
        $newprice = $request->input('harga')*$request->input('jumlah');
        $selisih = $gudang->price - $newprice; //untuk perhitungan ulang hutang piutang
        $gudang->price  = $newprice;
        $gudang->type   = $request->input('tipe');
        if($gudang->save()){
            $transaction_detail = TransactionDetails::find($gudang->transaction_detail_id);
            if ($transaction_detail) {
              $transaction_detail->amount = $gudang->price;

              if($request->input('tipe')=='Keluar'){
                  $multiplier = 1;
                  $transaction_detail->account_id = Barang::find($gudang->item_id)->sale_account_id;
               }elseif ($request->input('tipe')=='Masuk') {
                  $multiplier = -1;
                  $transaction_detail->account_id = Barang::find($gudang->item_id)->purchase_account_id;
              }

              if (!$transaction_detail->save())
                  return redirect()->back()->with('merah','Opps! Ada masalah saat penambahan, silahkan ulangi.');

              $transaction_detail2 = TransactionDetails::where('transaction_id', $transaction_detail->transaction_id)
                                                          ->where('item_id', null)
                                                          ->first();
              $transaction_detail2->amount = (abs($transaction_detail2->amount) - $selisih) * $multiplier;
              if (!$transaction_detail2->save())
                  return redirect()->back()->with('merah','Opps! Ada masalah saat penambahan, silahkan ulangi.');
            }
            return redirect()->route('barang.show',$gudang->item_id)->with('hijau','Penambahan data gudang berhasil.');

        }else{
            return redirect()->back()->with('merah','Opps! Ada masalah saat penambahan, silahkan ulangi.');
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
        $gudang = Gudang::find($id);

        $transaction_detail_hutang_piutang = TransactionDetails::where('transaction_id', $gudang->transactionDetails->transaction_id)
                                                    ->where('item_id', null)
                                                    ->first();
        $multiplier = 1;
        if ($transaction_detail_hutang_piutang->account->group_id == 7) $multiplier = -1; //kalo hutang dibuat minus

        $transaction_detail_hutang_piutang->amount = (abs($transaction_detail_hutang_piutang->amount) - $gudang->price) * $multiplier;
        if (!$transaction_detail_hutang_piutang->save())
            return redirect()->back()->with('merah','Oops! Ada masalah saat proses hapus data gudang, silahkan ulangi');

        if(TransactionDetails::destroy($gudang->transaction_detail_id)){
            return redirect()->back()->with('hijau','Data gudang berhasil dihapus!');
        }else{
            return redirect()->back()->with('merah','Oops! Ada masalah saat proses hapus data gudang, silahkan ulangi');
        }
    }

    public function transfer(){
        $tank = Tank::with('gudang')->where('stock','!=',2)->get();
        return view('gudang.transfer',['tank'=>$tank]);
    }

    public function susut($id, Request $request){
        $tank = Gudang::where('tank_id',$id)->first();
        $susut = new Gudang();
        $susut->item_id = $tank->item_id;
        $susut->amount_out = $request->input('susut');
        $susut->tank_id = $id;
        $susut->type = "Susut";
        $susut->notes = "Susut";
        if( $susut->save()){
            return redirect()->route('tank.index')->with('hijau','Penyusutan berhasil disimpan.');
        }else{
            return redirect()->back()->with('merah','Oops! Ada masalah saat proses penyusutan tangki, silahkan ulangi');
        }

    }

    public function postTransfer(Request $request){
        $tank = Gudang::where('tank_id',$request->input('dari'))->first();
        // return $tank->item_id;
        $dari = new Gudang();
        $dari->item_id = $tank->item_id;
        $dari->amount_out = $request->input('jumlah');
        $dari->tank_id = $request->input('dari');
        $dari->type   = "Transfer ke";
        $dari->notes = json_encode(['tank_id'=>$request->input('ke')]);
        $ke = new Gudang();
        $ke->item_id = $tank->item_id;
        $ke->amount_in = $request->input('jumlah');
        $ke->tank_id = $request->input('ke');
        $ke->type   = "Transfer dari";
        $ke->notes = json_encode(['tank_id'=>$request->input('dari')]);
        if( $dari->save() && $ke->save()){
            return redirect()->route('tank.index');
        }else{
            return redirect()->back();
        }

    }

    public function excelIndexGudang(){
        $items = $this->getIndexGudang();

        Excel::create('Index Gudang', function($excel) use($items) {
            
            $excel->sheet('1', function($sheet) use($items) {
                $sheet->loadView('excel.indexGudang',['gudang'=>$items]);
            });
        })->download('xls');
    }

}
