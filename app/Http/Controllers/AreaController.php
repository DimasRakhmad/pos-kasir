<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Area;
use Maatwebsite\Excel\Facades\Excel;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Area::all();
        return view('area.index', ['items' => $items]);
    }
    public function exportArea ()
    {
        $items = Area::all();
        Excel::create('Area Meja ', function ($excel) use ($items) {
            $excel->sheet('1', function ($sheet) use ($items) {
                $sheet->loadView('area.excelarea', ['items' => $items,]);
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
        return view('area.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Area();
        $item->name = $request->input('name');
        if($item->save()){
            return redirect()->route('area.index')->with('hijau','Succeed');
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
        $item = Area::find($id);
        return view('area.edit',['item'=>$item]);
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
        $item = Area::find($id);
        $item->name = $request->input('name');
        if($item->save()){
            return redirect()->route('area.index')->with('hijau','Succeed');
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
        if (Area::destroy($id)) {
            return redirect()->back()->with('hijau', 'Data table berhasil dihapus!');
        } else {
            return redirect()->back()->with('merah', 'Oops! Ada masalah saat proses hapus data, silahkan ulangi');
        }
    }
    public function kasir()
    {        
        $items = Area::all();
        return view('pos.area', ['items' => $items]);

    }
    public function waiter()
    {
        $level = \DB::table('role_user')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('role_user.user_id', session('id'))
            ->select('roles.*')
            ->first();
        session()->put('level', $level->name);
        $items = Area::all();
        return view('waiter.area', ['items' => $items]);

    }
}
