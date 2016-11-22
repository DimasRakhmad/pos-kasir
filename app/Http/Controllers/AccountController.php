<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountGroup;

class AccountController extends Controller
{
    public function searchAccounts($keyword)
    {
        $accounts = Account::where('name', 'like', $keyword.'%')
                                ->get();
        return response()->json($accounts);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account = Account::with('accounting')->where('account_group_id','!=',10)->get();
        // return $account;
        return view('account.index',['items'=>$account]);
    }

    public function piutangKaryawan()
    {
        $account = Account::where('account_group_id',10)->with('accounting')->get();
        // return $account;
        return view('account.piutang',['items'=>$account]);
    }

    public function piutangKaryawanPOS()
    {
        $account = Account::where('account_group_id',10)->with('accounting')->get();
        // return $account;
        return view('account.piutang-pos',['items'=>$account]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = AccountGroup::all();
        return view('account.create',['groups'=>$groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Account();
        $item->name = $request->input('name');
        $item->account_group_id = $request->input('group_id');
        if($item->save()){
            return redirect()->route('account.index')->with('hijau','Succeed');
        }else{
            return redirect()->back()->with('merah', 'Opps! Something error');
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
        $account = Account::with('accounting.transaction.detail')->find($id);
        // return $account;
        return view('account.show',['items'=>$account]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Account::find($id);
        $groups = AccountGroup::all();
        return view('account.edit',['item'=>$item,'groups'=>$groups]);
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
        $item = Account::find($id);
        $item->name = $request->input('name');
        $item->account_group_id = $request->input('group_id');
        if($item->save()){
            return redirect()->route('account.index')->with('hijau','Succeed');
        }else{
            return redirect()->back()->with('merah', 'Opps! Something error');
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
        if (Account::destroy($id)) {
            return redirect()->back()->with('hijau', 'Succeed');
        } else {
            return redirect()->back()->with('merah', 'Oops! Something error');
        }
    }
}
