<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Item;
use App\Models\Recipe;
use Maatwebsite\Excel\Facades\Excel;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Menu::with('category')->get();
        return view('menu.index', ['items' => $items]);
    }
    public function exportMenu ()
    {
        $items = Menu::with('category')->get();
        Excel::create('Menu ', function ($excel) use ($items) {
            $excel->sheet('1', function ($sheet) use ($items) {
                $sheet->loadView('menu.excelmenu', ['items' => $items,]);
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
        $category = Category::all();
        $items = Item::all();

        return view('menu.create', compact('category', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $search = \DB::table('menus')->where('code', $request->input('code'))->count();

        if ($search > 0) {
            return redirect()->back()->with('merah', 'code sudah terpakai');
        } else {
            $item = new Menu();
            $item->name = $request->input('name');
            $item->category_id = $request->input('category_id');
            $item->code = $request->input('code');
            $item->price = $request->input('price');
            $item->description = $request->input('description');
            if ($item->save()) {
                $items = $request->get('item');
                $recipe = $request->get('recipe');

                foreach ($items as $key => $value) {
                    $recipes = Recipe::create(['item_id' => $value, 
                                               'menu_id' => $item->id,
                                               'amount' => $recipe[$key]]);

                }
                return redirect()->route('menu.index')->with('hijau', 'Tambah Data Berhasil');
            } else {
                return back()->with('merah', 'Data Gagal disimpan');
            }
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
        $recipe = Recipe::where('menu_id', $id)->get();
        $items = Item::all();
        $category = Category::all();
        $item = Menu::find($id);
        return view('menu.edit', compact('recipe','category', 'item', 'items'));
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
        // return $request->all();
        $item = Menu::find($id);
        $item->name = $request->input('name');
        $item->category_id = $request->input('category_id');
        $item->code = $request->input('code');
        $item->price = $request->input('price');
        $item->description = $request->input('description');
//        $item->type = $request->input('type');

        if ($item->save()) {
                $items = $request->get('item');
                $recipe = $request->get('recipe');

                $recipes = Recipe::where(['menu_id' => $item->id])->delete();

                foreach ($items as $key => $value) {                  
                    $recipes = new Recipe;                                        
                    $recipes->item_id = $value;
                    $recipes->menu_id = $item->id;
                    $recipes->amount = $recipe[$key];
                    $recipes->save();
                }
            return redirect()->route('menu.index')->with('hijau', 'Ubah Data Item Berhasil');
        } else {
            return redirect()->back()->with('merah', 'Oops! Ada masalah saat proses pengubahan data, silahkan ulangi');
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
        if (Menu::destroy($id)) {
            return redirect()->back()->with('hijau', 'Data Item berhasil dihapus!');
        } else {
            return redirect()->back()->with('merah', 'Oops! Ada masalah saat proses hapus barang, silahkan ulangi');
        }
    }
}
