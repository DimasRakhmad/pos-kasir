<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Accounts;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $partner = Partner::with('account')->get();
        return view('partner.index',['partner'=>$partner]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $deadline = collect([['value' => 0, 'name' => 'Di Hari Yang Sama (Tunai)'],['value' => 3, 'name' => '3 Hari'],['value' => 10, 'name' => '10 Hari'],['value' => 7, 'name' => 'Satu Minggu'],['value' => 14, 'name' => 'Dua Minggu'],['value' => 30, 'name' => 'Satu Bulan'],]);
        $deadline->toArray();
        // return $deadline;
        return view('partner.create',['deadline'=>$deadline]);
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
        $account = new Accounts();
        if($request->input('type')=='Supplier'){
            $account->group_id = 7;
            $account->name = "Hutang ".$request->input('company');
        }elseif ($request->input('type')=='Customer'){
            $account->group_id = 8;
            $account->name = "Piutang ".$request->input('company');
        }
        $account->save();
        $partner                   = new Partner();
        $partner->name             = $request->input('name');
        $partner->company          = $request->input('company');
        $partner->phone            = $request->input('phone');
        $partner->payment_deadline = $request->input('payment_deadline');
        $partner->type             = $request->input('type');
        $partner->account_id       = $account->id;
        if($partner->save()){
            return redirect()->route('partner.index')->with('hijau','Tambah Data '.$partner->type.' Berhasil');
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
        $deadline = collect([['value' => 0, 'name' => 'Di Hari Yang Sama (Tunai)'],['value' => 3, 'name' => '3 Hari'],['value' => 10, 'name' => '10 Hari'],['value' => 7, 'name' => 'Satu Minggu'],['value' => 14, 'name' => 'Dua Minggu'],['value' => 30, 'name' => 'Satu Bulan'],]);
        $deadline->toArray();
        $partner = Partner::find($id);
        return view('partner.edit',['partner'=>$partner,'deadline'=>$deadline]);
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
        $partner                   = Partner::find($id);
        $partner->name             = $request->input('name');
        $partner->company          = $request->input('company');
        $partner->phone            = $request->input('phone');
        $partner->payment_deadline = $request->input('payment_deadline');
        $partner->type             = $request->input('type');
        $account                   = Accounts::find($partner->account_id);
        if($request->input('type')=='Supplier'){
            $account->group_id = 7;
            $account->name = "Hutang ".$request->input('company');
        }elseif ($request->input('type')=='Customer'){
            $account->group_id = 8;
            $account->name = "Piutang ".$request->input('company');
        }
        $account->save();

        if($partner->save()){
            return redirect()->route('partner.index')->with('hijau','Ubah Data '.$partner->type.' Berhasil');
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
        $partner = Partner::find($id);
        $account = Accounts::find($partner->account_id);

        if($partner->delete() && $account->delete()){
            return redirect()->route('partner.index')->with('hijau','Hapus Data Berhasil');
        }else{
            return redirect()->route('partner.index')->with('merah','Opps! Ada masalah saat penghapusan data, silahkan ulangi');
        }
    }
}
