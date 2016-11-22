<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\AccountGroups;
use App\Models\Transactions;
use App\Models\TransactionDetails;
use DB;
use Excel;

class AccountsController extends Controller
{
    /**
     * [getIndexBiaya description]
     * @param  [type] $tanggal [description]
     * @return [type]          [description]
     */
    public function getIndexBiaya($tanggal){
        return Accounts::with(['transaction'=>function ($query) use ($tanggal){
            $query->whereRaw("DATE_FORMAT(transactions.transaction_date,'%Y-%m') = '$tanggal'");
        }])->where('group_id',3)->orWhere('group_id',4)->get();
    }

    public function getDetailBiaya($date,$id){
        return Accounts::with(['transaction'=>function ($query) use ($date){
            $query->whereRaw("DATE_FORMAT(transactions.transaction_date,'%Y-%m') = '$date'");
        }])->find($id);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Accounts::with('accountGroup')->with('transaction')->get();
        return view('content.account.index',['accounts'=>$accounts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grup = AccountGroups::all();
        return view('content.account.create',['grup'=>$grup]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $akun=new Accounts();
        $akun->group_id=$request->input('group_id');
        $akun->code=$request->input('code');
        $akun->name=$request->input('name');
        $akun->notes=$request->input('notes');
        if($akun->save()){
            return redirect()->route('accounts.index')->with('sukses','Berhasil menambah akun '.$akun->name);
        }else{
            return redirect()->back()->with('gagal','Gagal menambah');
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
        $begin = date('Y-m-d',strtotime(date('Y-01-01')));
        $end = date('Y-m-d');
        $jurnal = DB::table('transaction_details')
                        ->join('transactions', 'transactions.id','=','transaction_details.transaction_id')
                        ->join('accounts', 'accounts.id', '=', 'transaction_details.account_id')
                        ->where('accounts.id', $id)
                        ->whereBetween('transactions.transaction_date', [$begin, $end])
                        ->orderBy('accounts.code')
                        ->select('transactions.transaction_code as trans_code', 'transactions.transaction_date', 'transaction_details.amount', 'transaction_details.item_name', 'accounts.code as account_code', 'accounts.name as name')
                        ->get();

        $jurnalName = Accounts::find($id);
        return view('content.account.show',['account_id' => $id,'jurnal'=>$jurnal,'end'=>$end,'begin'=>$begin,'jurnalName'=>$jurnalName]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account = Accounts::find($id);
        $grup = AccountGroups::all();
        return view('content.account.edit',['account'=>$account,'grup'=>$grup]);
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
        $akun =  Accounts::find($id);
        $akun->group_id=$request->input('group_id');
        $akun->code=$request->input('code');
        $akun->name=$request->input('name');
        $akun->notes=$request->input('notes');
        if($akun->save()){
            return redirect()->route('accounts.index')->with('sukses','Berhasil memperbaharui akun '.$akun->name);
        }else{

            return redirect()->back()->with('gagal','Gagal memperbaharui');
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
        if(Accounts::destroy($id)){
            return redirect()->back()->with('sukses','Berhasil menghapus');
        }else{
            return redirect()->back()->with('gagal','Gagal menghapus');
        }
    }

    // Additional Function
    public function searchAccounts($keyword)
    {
        $accounts = Accounts::Where('name', 'like', '%'.$keyword.'%')
                                ->get();
        return response()->json($accounts);
    }

    public function getDetailsByDate($id, $begin, $end)
    {
        $jurnal = DB::table('transaction_details')
                        ->join('transactions', 'transactions.id','=','transaction_details.transaction_id')
                        ->join('accounts', 'accounts.id', '=', 'transaction_details.account_id')
                        ->where('accounts.id', $id)
                        ->whereBetween('transactions.transaction_date', [$begin, $end])
                        ->orderBy('accounts.code')
                        ->select('transactions.transaction_code as trans_code', 'transactions.transaction_date', 'transaction_details.amount', 'transaction_details.item_name', 'accounts.code as account_code', 'accounts.name as name')
                        ->get();
        $jurnalName = Accounts::find($id);
        return view('content.account.show',['account_id' => $id,'jurnal'=>$jurnal,'end'=>$end,'begin'=>$begin,'jurnalName'=>$jurnalName]);
    }
    // End of Additional Function

    public function indexBiaya($date=NULL){

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
        // Grup 3 = Biaya Operasional Grup 4 = Biaya Non Operasional
        if($date==NULL){
            $tanggal = date('Y-m');
        }else{
            $tanggal = date('Y').'-'.$date;
        }
        // return $date;
        $akun = $this->getIndexBiaya($tanggal);
        // return $akun;
        return view('biaya.indexBiaya',['items'=>$akun,'tigaBulan'=>$tigaBulan,'date'=>$tanggal]);
    }

    public function createBiaya(){
        $jenis = collect([
                ['id'=>'3','name'=>'Biaya Operasional'],
                ['id'=>'4','name'=>'Biaya Non Operasional']
            ]);
        // return $jenis;
        return view('biaya.create');
    }

    public function postBiaya(Request $request){
        $akun=new Accounts();
        $akun->group_id=$request->input('jenis');
        $akun->name=$request->input('name');
        $akun->notes=$request->input('deskripsi');
        if($akun->save()){
            return redirect()->to(url('biaya'))->with('hijau','Berhasil menambah biaya baru');
        }else{
            return redirect()->back()->with('gagal','Opps! Ada masalah saat menambah');
        }
    }

    public function createDana(){
        $akun = Accounts::where('group_id',6)->where('name','!=','Giro')->orWhere('group_id',10)->get();
        $biaya = Accounts::where('group_id',3)->where('id','!=',4)->where('id','!=',5)->where('id','!=',9)->orWhere('group_id',4)->get();
        return view('biaya.bayar',['akun'=>$akun,'biaya'=>$biaya]);
    }

    public function postDana(Request $request){
        $date = $request->input('tanggal');
        // Buat Transaksi baru

        $transaction             = new Transactions();
        $transaction->name = "Biaya [".$date."]";
        $transaction->transaction_code = $request->input('no_resi');

        $transaction->transaction_date = date("Y-m-d", strtotime($date));
        $transaction->save();
        $data = $request->input('item');
        $total = 0;
        foreach ($data as $key) {
            # Debit Akun Biaya
            $tran                 = new TransactionDetails();
            $tran->transaction_id = $transaction->id;
            $tran->amount         = $key['amount'];
            $tran->keterangan     = $key['deskripsi'];
            $tran->account_id     = $key['id_biaya'];
            $tran->save();
            $total+=$key['amount'];
        }
        // Kredit Akun Sumber
        $tran                 = new TransactionDetails();
        $tran->transaction_id = $transaction->id;
        $tran->amount         = -1*$total;
        $tran->account_id     = $request->input('sumber_id');
        $tran->save();

        return redirect()->to(url('biaya'))->with('hijau','Proses pembayaran berhasil');

    }

    public function detailBiaya($date,$id){
        $items = $this->getDetailBiaya($date,$id);
        // return $items;
        return view('biaya.show',['items'=>$items,'date'=>$date,'id'=>$id]);
    }

    public function excelIndexBiaya($date=NULL){
        if($date==NULL){
            $tanggal = date('Y-m');
        }else{
            $tanggal = date('Y').'-'.$date;
        }
        // return $date;
        $akun = $this->getIndexBiaya($tanggal);

        Excel::create('Biaya '.date('Y-m-d'), function($excel) use($akun) {
            
            $excel->sheet('Biaya Operasional', function($sheet) use($akun) {
                $sheet->loadView('excel.indexBiaya',['items'=>$akun]);
            });
            $excel->sheet('Biaya Non Operasional', function($sheet) use($akun) {
                $sheet->loadView('excel.indexBiayaNon',['items'=>$akun]);
            });
        })->download('xls');
    }

    public function excelDetilBiaya($date,$id){
        $items = $this->getDetailBiaya($date,$id);

        Excel::create('Detil Biaya '.$items->name.' '.date('Y-m-d'), function($excel) use($items) {
            
            $excel->sheet('1', function($sheet) use($items) {
                $sheet->loadView('excel.detilBiaya',['items'=>$items]);
            });
        })->download('xls');
    }

    public function editBiaya($id){
        $item = Accounts::find($id);
        // return $item;
        return view('biaya.edit',['item'=>$item]);
    }

    public function updateBiaya(Request $request, $id){
        $akun = Accounts::find($id);
        $akun->group_id=$request->input('jenis');
        $akun->name=$request->input('name');
        $akun->notes=$request->input('deskripsi');
        if($akun->save()){
            return redirect()->to(url('biaya'))->with('hijau','Berhasil menambah biaya baru');
        }else{
            return redirect()->back()->with('gagal','Opps! Ada masalah saat menambah');
        }
        
    }


    public function detilBiayaEdit($id){
        $items = Transactions::with('transactionDetails')->find($id);
        $akun = Accounts::where('group_id',6)->where('name','!=','Giro')->orWhere('group_id',10)->get();
        $biaya = Accounts::where('group_id',3)->where('id','!=',4)->where('id','!=',5)->where('id','!=',9)->orWhere('group_id',4)->get();
        // return $biaya;
        // return view('biaya.bayar',);
        foreach ($items->transactionDetails as $key => $value) {
            # code...
            if($value->amount < 0){
                $items['sumber'] = $value;
                unset($items->transactionDetails[$key]);
            }
        }
        // return $items;
        return view('biaya.editBayar',['items'=>$items,'akun'=>$akun,'biaya'=>$biaya]);
    }

    public function detilBiayaUpdate($id,Request $request){
        $date = $request->input('tanggal');
        // Buat Transaksi baru

        $transaction             = Transactions::find($id);
        $transaction->delete();
        $transaction             = new Transactions();
        $transaction->name = "Biaya [".$date."]";
        $transaction->transaction_code = $request->input('no_resi');

        $transaction->transaction_date = date("Y-m-d", strtotime($date));
        $transaction->save();
        $data = $request->input('item');
        $total = 0;
        foreach ($data as $key) {
            # Debit Akun Biaya
            $tran                 = new TransactionDetails();
            $tran->transaction_id = $transaction->id;
            $tran->amount         = $key['amount'];
            $tran->keterangan     = $key['deskripsi'];
            $tran->account_id     = $key['id_biaya'];
            $tran->save();
            $total+=$key['amount'];
        }
        // Kredit Akun Sumber
        $tran                 = new TransactionDetails();
        $tran->transaction_id = $transaction->id;
        $tran->amount         = -1*$total;
        $tran->account_id     = $request->input('sumber_id');
        $tran->save();

        return redirect()->to(url('biaya'))->with('hijau','Update data berhasil');

    }
}
