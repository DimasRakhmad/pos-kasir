<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\TableAreas;
use App\Models\Area;
use App\Models\Table;
use Illuminate\Http\Request;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Table::all();
        return view('table.index', ['items' => $items]);

    }
    public function exportTable ()
    {
        $items = Table::all();
        Excel::create('Meja ', function ($excel) use ($items) {
            $excel->sheet('1', function ($sheet) use ($items) {
                $sheet->loadView('table.exceltable', ['items' => $items,]);
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
        $areas = Area::all();
        return view('table.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Table();
        $item->area_id = $request->input('area_id');
        $item->code = $request->input('code');
        $item->name = $request->input('name');
        if ($item->save()) {
            return redirect()->route('table.index')->with('hijau', 'Table added');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $area = Area::all();
        $item = Table::find($id);
        return view('table.edit', ['item' => $item, 'area' => $area]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $item = Table::find($id);
        $item->area_id = $request->input('area_id');
        $item->code = $request->input('code');
        $item->name = $request->input('name');
        if ($item->save()) {
            return redirect()->route('table.index')->with('hijau', 'Table updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Table::destroy($id)) {
            return redirect()->back()->with('hijau', 'Data table berhasil dihapus!');
        } else {
            return redirect()->back()->with('merah', 'Oops! Ada masalah saat proses hapus data, silahkan ulangi');
        }
    }

    public function kasir($area_id)
    {
        $level = \DB::table('role_user')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('role_user.user_id', Auth::user()->id)
            ->select('roles.*')
            ->first();
        session()->put('level', $level->name);
        $items = Table::where('area_id', $area_id)->get();
//        return ($items);
        return view('pos.tables', ['items' => $items]);

    }
    public function waiter($id)
    {
        $level = \DB::table('role_user')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('role_user.user_id', session('id'))
            ->select('roles.*')
            ->first();
        session()->put('level', $level->name);
        $items = Table::where('area_id', $id)->get();
        return view('waiter.tables', ['items' => $items]);

    }
}
