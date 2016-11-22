<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\Transactions;
use App\Models\TransactionDetails;
use App\Models\Purchase;
use App\Models\Items;
use App\Models\AccountingTransaction;
use Auth;
use Maatwebsite\Excel\Facades\Excel;


class StockController extends Controller
{
    public function getStock(){
      return Stock::with('barang')->groupBy('item_id')->selectRaw('*, sum(amount_in) as sum_in, sum(amount_out) as sum_out')->get();
    }

    public function index()
    {
        $items = Items::with('stock')->get();
        // return $items;
        return view('stock.index',['items'=>$items]);
    }
    public function exportStock ()
    {
        $items = Items::with('stock')->get();
        Excel::create('Stock ', function ($excel) use ($items) {
            $excel->sheet('1', function ($sheet) use ($items) {
                $sheet->loadView('stock.excelstock', ['items' => $items,]);
            });
        })->download('xls');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = Items::all();
        return view('stock.create',['items'=>$item]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        // $trans      = new Transactions();
        $date       = $request->input('tanggal');
        $tipe_bayar = $request->input('bayar');
        $total      = 0;
    
        $transaction          = new Transactions();
        $transaction->name    = "Pembelian ke ".$request->input('supplier')." [".$date."]";
        // set belum dibayar
        $transaction->code    = $request->input('no_resi');
        $transaction->type    = "Purchase";
        $transaction->inputer = Auth::user()->id;
        $transaction->date    = date("Y-m-d", strtotime($date));
        $transaction->total   = 0;
        $transaction->save();

        $id_barang = $request->input('id_barang');
        $jumlah    = $request->input('jumlah');
        $harga     = $request->input('harga');

        $purchase                 = new Purchase();
        $purchase->transaction_id = $transaction->id;
        $purchase->supplier       = $request->input('supplier');
        foreach ($id_barang as $key => $value) {
            /*
            Save detail transaksi
             */
            $detail                 = new TransactionDetails();
            $detail->transaction_id = $transaction->id;
            $detail->item_id        = $value;
            $detail->price          = $harga[$key];
            $detail->qty            = $jumlah[$key];
            $detail->subtotal       = $jumlah[$key]*$harga[$key];
            $detail->total          = $jumlah[$key]*$harga[$key];
            $detail->save();
            $total+=$detail->total;
            /*
            Stock
             */
            $stock = new Stock();
            $stock->item_id = $value;
            $stock->amount = $jumlah[$key];
            $stock->date = date("Y-m-d", strtotime($date));
            $stock->type = "in";
            $stock->save();
        }
        /*
        Save total transaksi
         */
        $transaction->total = $total;
        $transaction->save();

        /*
        Accounting Process
         */
        /*
        Kredit akun kas
         */
        $accounting                 = new AccountingTransaction();
        $accounting->transaction_id = $transaction->id;
        $accounting->account_id     = 1;
        $accounting->amount         = -1*$total;
        $accounting->notes          = "Kredit ".$transaction->name;
        $accounting->save();
        /*
        Debit akun Pembelian
         */
        $accounting                 = new AccountingTransaction();
        $accounting->transaction_id = $transaction->id;
        $accounting->account_id     = 2;
        $accounting->amount         = $total;
        $accounting->notes          = "Debit ".$transaction->name;
        $accounting->save();

        return redirect()->route('stock.index')->with('hijau','Transaksi Berhasil');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $items = Items::with('stock')->find($id);
        // return $items;
        return view('stock.show',['items'=>$items]);
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
    }
}
