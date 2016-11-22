<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\CategoryItems;
use App\Models\Item;
use App\Models\Items;
use App\Models\Menu;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ItemsController extends Controller
{
    public function getItem()
    {
        return Item::all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $level = \DB::table('role_user')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('role_user.user_id', session('id'))
            ->select('roles.*')
            ->first();

        session()->put('level', $level->name);
        $items = Items::all();
//        return $items;
        return view('items.index', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Items();
        $item->name = $request->input('name');
        $item->unit = $request->input('unit');
        $item->description = $request->input('description');
        if ($item->save()) {
            return redirect()->route('items.index')->with('hijau', 'Tambah Data Item Berhasil');
        } else {
            return redirect()->back()->with('merah', 'Data Gagal disimpan');
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
        return Menu::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $Category = CategoryItems::all();
        $item = Items::find($id);
        return view('items.edit', ['item' => $item, 'category' => $Category]);
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
        $item = Items::find($id);
        $item->name = $request->input('name');
        $item->unit = $request->input('unit');
        $item->description = $request->input('description');
        if ($item->save()) {
            return redirect()->route('items.index')->with('hijau', 'Ubah Data Item Berhasil');
        } else {
            return redirect()->back()->with('merah', 'Oops! Ada masalah saat proses pengubahan data, silahkan ulangi');
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
        //
        if (Items::destroy($id)) {
            return redirect()->back()->with('hijau', 'Data Item berhasil dihapus!');
        } else {
            return redirect()->back()->with('merah', 'Oops! Ada masalah saat proses hapus barang, silahkan ulangi');
        }
    }

    public function filter($id)
    {
        if ($id == '*') {
            return Menu::all();
        } else {
            return Menu::where('category_id', $id)->get();
        }
    }

    public function messages()
    {
        return [
            'code.unique' => 'Kode sudah terpakai',
        ];
    }

    public function exportItems ()
    {
        $items = Items::all();
        Excel::create('Barang ', function ($excel) use ($items) {
            $excel->sheet('1', function ($sheet) use ($items) {
                $sheet->loadView('items.excelitems', ['items' => $items,]);
            });
        })->download('xls');
    }
}