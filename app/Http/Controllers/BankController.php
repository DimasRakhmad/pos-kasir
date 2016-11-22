<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\EDC;
use Maatwebsite\Excel\Facades\Excel;

class BankController extends Controller
{

//    public function getDetilBank($id){
//        $payment    = EDC::find($id);
//        $account = Accounts::with('transaction')->with('transaction.transactionDetails.barang')->with('transaction.transactionDetails.gudang')->find($payment->account_id);
//        return $account;
//    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bank = EDC::all();
        // return $akun;
        return view('bank.index',['bank'=>$bank]);
    }
    public function exportBank ()
    {
        $bank = EDC::all();
        Excel::create('Mesin EDC ', function ($excel) use ($bank) {
            $excel->sheet('1', function ($sheet) use ($bank) {
                $sheet->loadView('bank.excelbank', ['bank' => $bank,]);
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
        // 
        
        return view('bank.create');
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
        $payment             = new EDC();
        $payment->name       = $request->input('name');
        if($request->input('kredit')=="true"){
            $kredit = new Account();
            $kredit->name= "Kredit ".$request->input('name');
            $kredit->account_group_id = 1;
            $kredit->save();
            $payment->account_kredit_id = $kredit->id;
        }
        if($request->input('debit')=="true"){
            $debit = new Account();
            $debit->name= "Debit ".$request->input('name');
            $debit->account_group_id = 1;
            $debit->save();
            $payment->account_debit_id = $debit->id;
        }
        if($payment->save()){
            return redirect()->route('bank.index')->with('hijau','Berhasil');
        }else{
            return redirect()->back()->with('merah','Gagal');
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

        $account = $this->getDetilBank($id);
        // return $account;
        return view('payment.show2',['items'=>$account,'id'=>$id]);
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
        $payment = EDC::find($id);
        return view('bank.edit',['bank'=>$payment]);
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
        // return $request->all();
        $payment             = EDC::find($id);
        // return $payment;
        $payment->name       = $request->input('name');
        if($request->input('kredit')=="true"){
            if(is_null($payment->account_kredit_id)){
                $kredit = new Account();
                $kredit->name= "Kredit ".$request->input('name');
                $kredit->account_group_id = 1;
                $kredit->save();
                $payment->account_kredit_id = $kredit->id;
            }else{
                $kredit = Account::find($payment->account_kredit_id);
                $kredit->name= "Kredit ".$request->input('name');
                $kredit->save();
            }
        }else{
            if(!is_null($payment->account_kredit_id)){
                $payment->account_kredit_id = NULL;
                Account::destroy($payment->account_kredit_id);
            }
        }
        if($request->input('debit')=="true"){
            if(is_null($payment->account_debit_id)){
                $kredit = new Account();
                $kredit->name= "Debit ".$request->input('name');
                $kredit->account_group_id = 1;
                $kredit->save();
                $payment->account_debit_id = $kredit->id;
            }else{
                $kredit = Account::find($payment->account_debit_id);
                $kredit->name = "Debit ".$request->input('name');
                $kredit->save();
            }
        }else{
            if(!is_null($payment->account_debit_id)){
                $payment->account_debit_id = NULL;
                Account::destroy($payment->account_debit_id);
            }
        }
        if($payment->save()){
            return redirect()->route('bank.index')->with('hijau','Berhasil');
        }else{
            return redirect()->back();
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
        if(EDC::destroy($id)){
            return redirect()->route('bank.index')->with('hijau','Berhasil menghapus');
        }else{
            return redirect()->back()->with('merah','Gagal menghapus');
        }
    }

    public function excelDetilBank($id){
        $items = $this->getDetilBank($id);

        Excel::create('Detil Bank', function($excel) use($items) {
            
            $excel->sheet('1', function($sheet) use($items) {
                $sheet->loadView('excel.detilBank',['items'=>$items]);
            });
        })->download('xls');
    }

    public function excelIndexBank(){
        $payment = EDC::with('account')->with('account.transaction')->paginate(10);
        $akun = Accounts::with('accountGroup')->with('transaction')->with('bank')->where('group_id',6)->Where('id','!=',2)->orWhere('group_id',10)->get();
        Excel::create('Mutasi Kas '.date('Y-m-d'), function($excel) use($payment, $akun) {
            
            $excel->sheet('1', function($sheet) use($payment, $akun) {
                $sheet->loadView('excel.indexBank',['payment'=>$payment,'items'=>$akun]);
            });
        })->download('xls');
    }
}
