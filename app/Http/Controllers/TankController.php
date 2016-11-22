<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tank;
use App\Models\Accounts;
use App\Models\Transactions;
use App\Models\TransactionDetails;
use App\Models\Gudang;
use Excel;

class TankController extends Controller
{
    public function getDetilTank($id){
        $tank = Tank::with('gudang')->with('gudang.partner')->orderBy('created_at','desc')->find($id);
        foreach($tank->gudang as $key){
            $note = json_decode($key->notes, true);
            if(is_array($note)){
                if(array_key_exists('tank_id',$note)){
                    $key['tank']=Tank::find($note['tank_id']);
                }
            }
            
        };
        return $tank;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tank = Tank::with('gudang')->where('stock','!=',2)->get();
        return view('tank.index',['tank'=>$tank]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('tank.create');
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
        $tank              = new Tank();
        $tank->name        = $request->input('name');
        if($request->input('driver')){
            $tank->driver      = $request->input('driver');
        }
        if($request->input('stock')){
            $tank->stock      = $request->input('stock');
        }
        if($tank->save()){
            return redirect()->route('tank.index')->with('hijau','Tambah Data tank Berhasil');
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
        $tank = $this->getDetilTank($id);
        
        // return $tank;
        return view('tank.show',['tank'=>$tank,'id'=>$id]);
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
        $tank = Tank::find($id);
        return view('tank.edit',['tank'=>$tank]);
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
        $tank              = Tank::find($id);
        $tank->name        = $request->input('name');
        if($request->input('driver')){
            $tank->driver      = $request->input('driver');
        }
        if($request->input('stock')){
            $tank->stock      = $request->input('stock');
        }
        if($tank->save()){
            return redirect()->route('tank.index')->with('hijau','Tambah Data tank diubah');
        }else{
            return redirect()->back()->with('merah','Oops! Ada masalah saat pengubahan data, silahkan ulangi');
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
        if(Tank::destroy($id)){
            return redirect()->back()->with('hijau','Data berhasil dihapus');
        }else{
            return redirect()->back();
        }
    }

    public function uangJalan($id){
        $akun = Accounts::where('group_id',6)->orWhere('group_id', 10)->get();
        return view('tank.uangJalan',['akun'=>$akun,'id'=>$id]);

    }

    public function uangJalanStore($id, Request $request){
        $tank = Tank::find($id);
        $transaction                   = new Transactions();
        $transaction->name             = "Pembayaran Uang Jalan ".$tank->name;
        $transaction->transaction_code = $request->input('transaction_code');
        $transaction->transaction_date = date("Y-m-d");
        $transaction->notes            = json_encode(['tank_id'=>$tank->id]);
        $transaction->save();
        // kredit giro
        $tran                 = new TransactionDetails();
        $tran->transaction_id = $transaction->id;
        $tran->account_id     = $request->input('account_id');
        $tran->amount         = -1*$request->input('amount');
        $tran->save();
        // Debit Bank
        $tran                 = new TransactionDetails();
        $tran->transaction_id = $transaction->id;
        $tran->account_id     = 3;
        $tran->amount         = $request->input('amount');
        $tran->save();

        return redirect()->route('tank.index');
    }

    public function riwayatSusut($id){
        $tank = Tank::with('gudang')->with('gudang.partner')->find($id);
        // return $tank;
        return view('tank.riwayatSusut',['tank'=>$tank]);
    }

    public function excelDetilTank($id){
        $items = $this->getDetilTank($id);
         Excel::create('Detil Tank '.$items->name, function($excel) use($items) {
            $excel->sheet('1', function($sheet) use($items) {
                $sheet->loadView('excel.detilTank',['tank'=>$items]);
            });
        })->download('xls');
    }

    public function susut(){
        $tank = Tank::with('gudang')->where('stock','!=',2)->get();
        return view('tank.susut',['tank'=>$tank]);
    }

    public function susutPost(Request $request){
        $tank              = Gudang::where('tank_id',$request->input('tank_id'))->first();
        $susut             = new Gudang();
        $susut->item_id    = $tank->item_id;
        $susut->amount_out = $request->input('jumlah');
        $susut->tank_id    = $request->input('tank_id');
        $susut->created_at = date("Y-m-d", strtotime($request->input('tanggal')));
        $susut->type       = "Susut";
        $susut->notes      = "Susut";
        if($susut->save()){
            return redirect()->route('tank.index')->with('hijau','Penyusutan berhasil disimpan.');
        }else{
            return redirect()->back()->with('merah','Oops! Ada masalah saat proses penyusutan tangki, silahkan ulangi');
        }
    }

    public function susutDestroy($id){
        if(Gudang::destroy($id)){
            return redirect()->back()->with('hijau','Berhasil hapus susut');
        }else{
            return redirect()->back()->with('merah','Oops! Ada masalah saat proses hapus');
        }
    }
}
