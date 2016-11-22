<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Account;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Employee::all();
        return view('employee.index', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $account = new Account();
        $account->name = "Piutang ".$request->input('name');
        $account->account_group_id = 10;
        $account->save();
        $item = new Employee();
        $item->name = $request->input('name');
        $item->account_id = $account->id;
        if($item->save()){
            return redirect()->route('member.index')->with('hijau','Succeed');
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
        $item = Employee::find($id);
        return view('employee.edit',['item'=>$item]);
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
        $item = Employee::find($id);
        $item->name = $request->input('name');
        $account = Account::find($item->account_id);
        $account->name = "Piutang ".$request->input('name');
        $account->save();
        if($item->save()){
            return redirect()->route('member.index')->with('hijau','Succeed');
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
        $member = Employee::find($id);
        Account::destroy($member->account_id);
        if ($member->delete()) {
            return redirect()->back()->with('hijau', 'Data table berhasil dihapus!');
        } else {
            return redirect()->back()->with('merah', 'Oops! Ada masalah saat proses hapus data, silahkan ulangi');
        }
    }
}
