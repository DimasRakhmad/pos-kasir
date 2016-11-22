<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Maatwebsite\Excel\Facades\Excel;

class CategoryItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $category = Category::all();
        return view('category.index', ['category' => $category]);
    }
    public function exportCategory ()
    {
        $category = Category::all();
        Excel::create('Category Menu ', function ($excel) use ($category) {
            $excel->sheet('1', function ($sheet) use ($category) {
                $sheet->loadView('category.excelcategory', ['category' => $category,]);
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
        //
        return view('category.create');
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
        $items = new Category();
        $items->name = $request->input('name');
        $items->description = $request->input('description');
        $items->print_location = $request->input('print_location');
        if ($items->save()) {
            return redirect()->route('category.index')->with('hijau', 'Tambah Data Category Item Berhasil');
        } else {
            return redirect()->back()->with('merah', 'Oops! Ada masalah saat penambahan data, silahkan ulangi');
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
        $items = Category::find($id);
        return view('category.edit', ['category' => $items]);

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
        $items = Category::find($id);
        $items->name = $request->input('name');
        $items->description = $request->input('description');
        $items->print_location = $request->input('print_location');
        if ($items->save()) {
            return redirect()->route('category.index')->with('hijau', 'Ubah Data Category Item Berhasil');
        } else {
            return redirect()->back()->with('merah', 'Oops! Ada masalah saat pengubahan data, silahkan ulangi');
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
        if(Category::destroy($id)){
            return redirect()->back()->with('hijau','Data Category Item berhasil dihapus!');
        }else{
            return redirect()->back()->with('merah','Oops! Ada masalah saat proses hapus category item, silahkan ulangi');
        }
    }
}
