<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Bank;
use App\Models\Giro;
use App\Models\Transactions;
use App\Models\TransactionDetails;
use App\Models\Karyawan;
use DB;

class HutangPiutangController extends Controller
{
    /** Keterangan Status
        -1 = belum lunas
        0 = lunas

    */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexHutang()
    {
        $items = Accounts::with('accountGroup')->with('transaction')->with('partner')->where('group_id',7)->get();
        // return $items;
        return view('laporan.hutang',['items'=>$items]);
    }

    public function indexPiutang()
    {
        //
        $items = Accounts::with('accountGroup')->with('transaction')->with('partner')->where('group_id',8)->get();
        return view('laporan.piutang',['items'=>$items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $begin = date('Y-m-d',strtotime(date('Y-01-01')));
        $end = date('Y-m-d');
        $items = Accounts::with('accountGroup')
                ->with(['transaction'=>function($query){
                    $query->where('transactions.status',-1)
                        ->orWhere('transactions.status',0);
                }])->with('partner')->with('transaction.transactionDetails')->with('transaction.transactionDetails.barang')->with('transaction.transactionDetails.gudang')->find($id);
        foreach ($items->transaction as $key) {
            $transaction = Transactions::with(['account'=>function($query) use ($id){
                $query->wherePivot('account_id','=',$id);
            }])->where('status',$key->id)->get();
            $key['min'] = $transaction;
            // $key['detil'] = $detil;
        }
        // return $items;
        return view('laporan.detilHP',['items'=>$items]);
    }

    public function showByCode($code){
        //
        $begin = date('Y-m-d',strtotime(date('Y-01-01')));
        $end = date('Y-m-d');
        $items = Transactions::with('transactionDetails')->with('transactionDetails.barang')->with('transactionDetails.gudang')->with('partner')->where('transaction_code','like','%'.$code.'%')->where(function($query){
                $query->where('status',-1)->orWhere('status',0);
        })->get();
        // return $items;
        // Mencari yang sudah dibayar berdasarkan status == transaction.id
        foreach ($items as $key => $value) {
            $transaction = Transactions::with(['account'=>function($query) use ($value) {
                $query->wherePivot('account_id','=',$value->partner->account_id);
            }])->where('status',$value->id)->get();
            $value['min'] = $transaction;
            $pivot = TransactionDetails::where('account_id',$value->partner->account_id)->where('transaction_id',$value->id)->first();
            $value['pivot'] = $pivot;
            // $account = Accounts::with('transaction')->with('accountGroup')->find($value->partner->account_id);
            // $value['account'] = $account;
        }
        // return $items;
        return view('laporan.detilHPByCode',['items'=>$items,'code'=>$code]);
    }

    public function payEdit($id){
        $item = Transactions::find($id);
        return $item;
    }

    public function detailHutang($id){

        $transaction = Transactions::find($id);
        $items = DB::table('transaction_details')
                    ->join('transactions','transactions.id','=','transaction_details.transaction_id')
                    ->join('stocks','stocks.transaction_detail_id','=','transaction_details.id')
                    ->join('items','items.id','=','transaction_details.item_id')
                    ->select('items.name as nama barang','stocks.unit_price as unit_price','stocks.amount_out as amount_out','stocks.amount_in as amount_in','stocks.price as price')
                    ->where('transactions.id',$id)
                    ->get();
        // return $items;
        return view('laporan.detil',['items'=>$items,'transaction'=>$transaction]);
    }

    public function daftarPiutangKaryawan(){

        $items = Transactions::with('account')->where('name','like','Kasbon%')->get();
        foreach ($items as $key) {
            # code...
            $note = json_decode($key->notes, true);
            $karyawan = Karyawan::find($note['employee_id']);
            $key['karyawan'] = $karyawan;
        }
        // return $items;
        return view('laporan.piutangKaryawan',['items'=>$items]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function listHutangPiutang($id){
        $akun   = Accounts::with('accountGroup')->with('transaction')->with('partner')->find($id);

        foreach ($akun->transaction as $key) {
            $transaction = Transactions::with('account')->where('status',$key->id)->get();
            $key['min'] = $transaction;
        }
        // return $akun;
        return view('laporan.listHutangPiutang',['akun'=>$akun]);
    }

    public function pay($id)
    {
        //
        // Accounts::with('accountGroup')->with('transaction')->with('partner')->where('group_id',7)->get();
        // $transaction = Transactions::with(['account'=>function($query) use ($id){
        //         $query->wherePivot('account_id','=',$id);
        //     }])->where('status',$key->id)->get();
        $tran = Transactions::with(['account'=>function($query){
            $query->where('accounts.group_id',7)->orWhere('accounts.group_id',8);
        }])->find($id);
        $account_id = $tran->account[0]->pivot->account_id;
        // return $account_id;
        $min = Transactions::with(['account'=>function($query) use ($account_id){
                $query->wherePivot('account_id','=',$account_id);
            }])->where('status',$tran->id)->get();

        $types  = Bank::all();
        $giro   = Giro::with('bank')->where('status',1)->get();
        // return $tran;
        // dd($min);
        return view('laporan.pay',['types'=>$types,'tran'=>$tran,'giro'=>$giro,'min'=>$min]);
    }

    // ga kepake
    public function payPiutang($id)
    {
        //
        $tran = Transactions::with(['account'=>function($query){
            $query->where('accounts.group_id',8);
        }])->find($id);
        $min = Transactions::with('account')->where('status',$tran->id)->get();
        // $akun  = Accounts::with('accountGroup')->with('transaction')->with('partner')->find($id);
        $types = Bank::all();
        // return $tran;
        return view('laporan.payPiutang',['types'=>$types,'tran'=>$tran,'min'=>$min]);
    }
    // end of ga kepake

    public function bayarHutangPiutang($id, Request $request){
        $transaction_detail = TransactionDetails::where('transaction_id', $id)->where('item_id', null)->first();
        if ($transaction_detail->amount >= 0) return $this->bayarPiutang($id, $request);
        else return $this->bayarHutang($id, $request);
    }

    private function bayarHutang($id, Request $request){
        $tipe = $request->input('type');
        //Ubah status hutang jadi sudah dibayar
        if($tipe=="giro" || $tipe=="pilih_giro"){
            if($request->input('nominal')>=$request->input('harus_bayar')){
                $t = Transactions::find($id);
                $t->status = 0;
                $t->save();
            }
        }else{
            if($request->input('amount')>=$request->input('harus_bayar')){

                $t = Transactions::find($id);
                $t->status = 0;
                $t->save();
            }
        }

        $akun = Accounts::find($request->input('account_id'));

        $transaction                   = new Transactions();
        $transaction->status           = $id;
        $transaction->name             = "Pembayaran ".$akun->name;
        $transaction->transaction_code = $request->input('transaction_code');
        $transaction->transaction_date = date("Y-m-d", strtotime($request->input('tanggal')));
        $transaction->save();
        // debit hutang
        $tran                 = new TransactionDetails();
        $tran->transaction_id = $transaction->id;
        $tran->account_id     = $akun->id;
        if($tipe == "giro"){
            $tran->amount         = $request->input('nominal');
        } elseif ($tipe == "pilih_giro"){
            $giro                  = Giro::find($request->input('giro_id'));
            $tran->amount         = $giro->nominal;
        } else{
            $tran->amount         = $request->input('amount');
        }

        $tran->save();

        if($tipe == "tunai"){
            // kredit akun kas (1)
            $tran2                 = new TransactionDetails();
            $tran2->transaction_id = $transaction->id;
            $tran2->account_id     = 1;
            $tran2->amount         = -1*$request->input('amount');
            $tran2->save();
        }elseif ($tipe=="transfer") {
            // kredit akun bank
            $payment = Bank::find($request->input('bank'));
            $tran2                 = new TransactionDetails();
            $tran2->transaction_id = $transaction->id;
            $tran2->account_id     = $payment->account_id;
            $tran2->amount         = -1*$request->input('amount');
            $tran2->save();
        }elseif ($tipe=="giro") {
            // Tambah giro
            $giro                  = new Giro();
            $giro->no_giro         = $request->input('no_giro');
            $giro->nominal         = $request->input('nominal');
            $giro->nama_bank       = Bank::find($request->input('nama_bank'))->name;
            $giro->tanggal_dibuat  = date("Y-m-d", strtotime($request->input('tanggal_dibuat')));
            $giro->tanggal_efektif = date("Y-m-d", strtotime($request->input('tanggal_efektif')));
            $giro->status           = 0;
            $giro->save();
            // Kredit akun bank penerbit giro
            $tran2                 = new TransactionDetails();
            $tran2->transaction_id = $transaction->id;
            $tran2->account_id     = Bank::find($request->input('nama_bank'))->account_id;
            $tran2->amount         = -1*$request->input('nominal');
            $tran2->giro_id        = $giro->id;
            $tran2->ket_giro       = "Baru";
            $tran2->save();
            $transaction->name     = "Pembayaran ".$akun->name." Giro ".$request->input('no_giro');
            $transaction->save();
        }elseif ($tipe="pilih_giro") {
            $giro2                 = Giro::find($request->input('giro_id'));
            $tran2                 = new TransactionDetails();
            $tran2->transaction_id = $transaction->id;
            $tran2->account_id     = 2;
            $tran2->amount         = -1*$giro2->nominal;
            $tran2->giro_id        = $giro2->id;
            $tran2->ket_giro       = "Lama";
            $tran2->save();
            $transaction->name     = "Pembayaran ".$akun->name." Giro ".$giro->no_giro;
            $transaction->save();
            $giro2->status         = 0;
            $giro2->save();
        }

        return redirect()->to(url('hutang'));
    }
    private function bayarPiutang($id, Request $request){
        //Ubah status hutang jadi sudah dibayar

        $tipe = $request->input('type');
        if($tipe=="giro"){
            if($request->input('nominal')>=$request->input('harus_bayar')){
                $t = Transactions::find($id);
                $t->status = 0;
                $t->save();
            }
        }else{
            if($request->input('amount')>=$request->input('harus_bayar')){
                $t = Transactions::find($id);
                $t->status = 0;
                $t->save();
            }
        }


        $akun = Accounts::find($request->input('account_id'));

        $transaction                   = new Transactions();
        $transaction->name             = "Pembayaran ".$akun->name;
        $transaction->status           = $id;
        $transaction->transaction_code = $request->input('transaction_code');
        $transaction->transaction_date = date("Y-m-d", strtotime($request->input('tanggal')));
        $transaction->save();

        // kredit piutang
        $tran                 = new TransactionDetails();
        $tran->transaction_id = $transaction->id;
        $tran->account_id     = $akun->id;
        if($tipe == "giro"){
            $tran->amount         = -1*$request->input('nominal');
        }else{
            $tran->amount         = -1*$request->input('amount');
        }
        $tran->save();

        if($tipe == "tunai"){
            // debit akun kas (1)
            $tran2                 = new TransactionDetails();
            $tran2->transaction_id = $transaction->id;
            $tran2->account_id     = 1;
            $tran2->amount         = $request->input('amount');
            $tran2->save();
        }elseif ($tipe=="transfer") {
            // debit akun bank
            $payment               = Bank::find($request->input('bank'));
            $tran2                 = new TransactionDetails();
            $tran2->transaction_id = $transaction->id;
            $tran2->account_id     = $payment->account_id;
            $tran2->amount         = $request->input('amount');
            $tran2->save();
        }elseif ($tipe=="giro") {
            // Tambah giro
            $giro                  = new Giro();
            $giro->no_giro         = $request->input('no_giro');
            $giro->nominal         = $request->input('nominal');
            $giro->nama_bank       = $request->input('nama_bank');
            $giro->tanggal_dibuat  = date("Y-m-d", strtotime($request->input('tanggal_dibuat')));
            $giro->tanggal_efektif = date("Y-m-d", strtotime($request->input('tanggal_efektif')));
            $giro->save();
            // debit akun giro
            $tran2                 = new TransactionDetails();
            $tran2->transaction_id = $transaction->id;
            $tran2->account_id     = 2;
            $tran2->amount         = $request->input('nominal');
            $tran2->giro_id        = $giro->id;
            $tran2->ket_giro       = "Baru";
            $tran2->save();
            $transaction->name     = "Pembayaran ".$akun->name." Giro ".$request->input('no_giro');
            $transaction->save();
        }

        return redirect()->to(url('piutang'));
    }

    public function cariHutangPiutang(Request $request){
        $code = $request->input('code');

        //  $items = Accounts::with('accountGroup')
        //         ->with(['transaction'=>function($query){
        //             $query->where('transactions.transaction_code','like','%'.$code.'%')
        //                 ->where('transactions.status',-1)
        //                 ->orWhere('transactions.status',0);
        //         }])->with('partner')->with('transaction.transactionDetails')
        //         ->with('transaction.transactionDetails.barang')->with('transaction.transactionDetails.gudang')->get();
        //         return $items;
        // foreach ($items->transaction as $key) {
        //     $transaction = Transactions::where('status',$key->id)->get();
        //     // $detil = Transactions::with('transactionDetails')->with('transactionDetails.barang')->with('transactionDetails.gudang')->find($key->id);
        //     $key['min'] = $transaction;
        //     // $key['detil'] = $detil;
        // }
        // return $items;where('group_id',7)
        $items = Transactions::with(['account'=>function($query){
                    $query->where('accounts.group_id','=',7)
                        ->orWhere('accounts.group_id','=',7);
                }])
                ->with('transactionDetails')
                ->with('transactionDetails.barang')
                ->with('transactionDetails.gudang')
                ->where('transaction_code','like','%'.$code.'%')
                ->where('status',-1)->orWhere('status',0)
                ->get();

                // return $items;
        foreach ($items as $key =>$value) {
            $transaction = Transactions::with(['account'=>function($query) use ($value){
                $query->wherePivot('account_id','=',$value->account[0]->id);
            }])->where('status',$value->id)->get();
            // $detil = Transactions::with('transactionDetails')->with('transactionDetails.barang')->with('transactionDetails.gudang')->find($key->id);
            $items[$key]['min'] = $transaction;
            // $key['detil'] = $detil;
        }
        // return $items;
        // dd($items);
        return view('laporan.hasilcari',['items'=>$items]);
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
        $transaction = Transactions::with('transactionDetails')->find($id);

        if ($transaction->status > 0) {
            // cari transaksi hutang piutang awalnya
            $root_transaction = Transactions::find($transaction->status);
            if ($root_transaction) {
                // Ubah status jadi belum lunas
                $root_transaction->status = -1;
                $root_transaction->save();
            }
        }

        // return $transaction;
        foreach ($transaction->transactionDetails as $key => $value) {
            if($value->giro_id){
                if($value->ket_giro == "Baru"){
                    Giro::destroy($value->giro_id);
                }elseif ($value->ket_giro == "Lama") {
                    $giro         = Giro::find($value->giro_id);
                    $giro->status = 1;
                    $giro->save();
                }
            }
        }

        $transaction->delete();

        return redirect()->back()->with('hijau','Hapus proses bayar berhasil');
    }
}
