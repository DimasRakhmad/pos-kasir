<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AccountGroups;

class AccountGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grup = AccountGroups::all();
        return view('content.accountGroup.index',['grup'=>$grup]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelompok=collect(['Harta','Hutang','Modal','Pendapatan','Biaya dan Beban']);
        return view('content.accountGroup.create',['kelompok'=>$kelompok]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $akun = new AccountGroups();
        $akun->name = $request->input('name');
        $akun->normal_balance = $request->input('normal_balance');
        $akun->category = $request->input('category');
        if($akun->save()){
            return redirect()->route('accounts-groups.index')->with('sukses','Berhasil menambah kelompok akun '.$akun->name);
        }else{
            return redirect()->back()->with('gagal','Ops! Silahkan tambah ulang.');
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
        $kelompok=collect(['Harta','Hutang','Modal','Pendapatan','Biaya dan Beban']);
        $grup = AccountGroups::find($id);
        return view('content.accountGroup.edit',['kelompok'=>$kelompok,'grup'=>$grup]);
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
        $akun = AccountGroups::find($id);
        $akun->name = $request->input('name');
        $akun->normal_balance = $request->input('normal_balance');
        $akun->category = $request->input('category');
        if($akun->save()){
            return redirect()->route('accounts-groups.index')->with('sukses','Berhasil memperbaharui kelompok akun '.$akun->name);
        }else{
            return redirect()->back()->with('gagal','Ops! Silahkan perbaharui lagi.');
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
        if(AccountGroups::destroy($id)){
             return redirect()->route('accounts-groups.index')->with('sukses','Berhasil menghapus');
        }else{
            return redirect()->route('accounts-groups.index')->with('gagal','Ops! Silahkan hapus lagi.');
        }
    }
}
