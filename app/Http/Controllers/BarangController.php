<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Accounts;
use App\Models\Transactions;
use App\Models\TransactionDetails;
use Session;
use Excel;
class BarangController extends Controller
{
    // Function detil barang
    public function getDetilBarang($id){
        $barang = Barang::with('gudang')->with('gudang.tank')->with('gudang.TransactionDetails.transactionDate')->find($id);
        foreach ($barang->gudang as $key => $value) {
            if($value->transaction_detail_id){
                $td = TransactionDetails::find($value->transaction_detail_id);
                $transactions = Transactions::find($td->transaction_id);
                $value['transaction_code'] = $transactions->transaction_code;
            }
        }

        return $barang;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // return Session::get('tes');
        $barang = Barang::all();
        return view('barang.index',['barang'=>$barang]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('barang.create');
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

        $akunPenjualan               = new Accounts();
        $akunPenjualan->group_id     = 1;
        $akunPenjualan->name         = "Penjualan ".$request->input('name');
        $akunPenjualan->save();
        $akunPembelian               = new Accounts();
        $akunPembelian->group_id     = 9;
        $akunPembelian->name         = "Pembelian ".$request->input('name');
        $akunPembelian->save();

        $barang                      = new Barang();
        $barang->name                = $request->input('name');
        $barang->description         = $request->input('deskripsi');
        $barang->unit                = $request->input('unit');
        $barang->sale_account_id     = $akunPenjualan->id;
        $barang->purchase_account_id = $akunPembelian->id;
        if($request->input('shrink')){
            $barang->shrink  = $request->input('shrink');
        }
        if($barang->save()){
            return redirect()->route('barang.index')->with('hijau','Tambah Data Barang Berhasil');
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
        $barang = $this->getDetilBarang($id);
        // dd($barang);
        // return $barang;
        return view('barang.show',['barang'=>$barang,'id'=>$id]);
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
        $barang=Barang::find($id);
        return view('barang.edit',['barang'=>$barang]);
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
        $barang              = Barang::find($id);
        $akunPembelian       = Accounts::find($barang->purchase_account_id);
        $akunPenjualan       = Accounts::find($barang->sale_account_id);
        $akunPenjualan->name = "Penjualan ".$request->input('name');
        $akunPenjualan->save();
        $akunPembelian->name = "Pembelian ".$request->input('name');
        $akunPembelian->save();
        $barang->name        = $request->input('name');
        $barang->description = $request->input('deskripsi');
        $barang->unit        = $request->input('unit');
        $barang->shrink      = $request->input('shrink');
        if($barang->save()){
            return redirect()->route('barang.index')->with('hijau','Tambah Data Barang Berhasil');
        }else{
            return redirect()->back()->with('merah','Oops! Ada masalah saat penambahan data, silahkan ulangi');
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
        if(Barang::destroy($id)){
            return redirect()->back()->with('hijau','Data barang berhasil dihapus!');
        }else{
            return redirect()->back()->with('merah','Oops! Ada masalah saat proses hapus barang, silahkan ulangi');
        }
    }

    public function excelDetilBarang($id){
        $items = $this->getDetilBarang($id);
         Excel::create('Detil barang '.$items->name, function($excel) use($items) {
            $excel->sheet('1', function($sheet) use($items) {
                $sheet->loadView('excel.detilBarang',['barang'=>$items]);
            });
        })->download('xls');
    }
}
