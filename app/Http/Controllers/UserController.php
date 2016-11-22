<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use App\User;
use Bican\Roles\Models\Role;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gantiPassword(){
        return view('gantiPassword');
    }

    public function gantiPasswordPost(Request $request){
        $hashedPassword = Auth::user()->password;
        $password_lama = $request->input('password_lama');
        $password_baru = $request->input('password_baru');
        $password_baru_lagi = $request->input('password_baru_lagi');
        if (Hash::check($password_lama, $hashedPassword)) {
            // The passwords match...
            if($password_baru == $password_baru_lagi){
                $user = User::find(Auth::user()->id);
                $user->password = Hash::make($password_baru);
                $user->save();
                return redirect()->back()->with('hijau','Berhasil');
            }else{
                return redirect()->back()->with('merah','Opps! Password baru tidak sama...');
            }
        }else{
            return redirect()->back()->with('merah','Opps! Password lama salah...');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = User::all();
        return view('user.index',['items'=>$items]);
    }
    public function exportUser ()
    {
        $items = User::all();
        Excel::create('User ', function ($excel) use ($items) {
            $excel->sheet('1', function ($sheet) use ($items) {
                $sheet->loadView('user.exceluser', ['items' => $items,]);
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
        $roles = Role::all();
        return view('user.create',['roles'=>$roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::find($request->input('role'));
        $user           = new User();
        $user->name     = $request->input('name');
        $user->email    = $request->input('email');
        $user->type     = $role->slug;
        $user->password = Hash::make($request->input('password'));
        if($user->save()){
            $user->attachRole($request->input('role'));
            return redirect()->to(url('user'))->with('hijau','Success');
        }else{
            return redirect()->back()->with('merah','Something Wrong!');
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
        $item = User::find($id);
        $roles = Role::all();
        return view('user.edit',['item'=>$item,'roles'=>$roles]);
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
        $role = Role::find($request->input('role'));
        $user = User::find($id);
        $user->name     = $request->input('name');
        $user->email    = $request->input('email');
        $user->type     = $role->slug;
        if($request->input('password'))
            $user->password = Hash::make($request->input('password'));
        if($user->save()){
            $user->detachAllRoles();
            $user->attachRole($request->input('role'));
            return redirect()->to(url('user'))->with('hijau','Success');
        }else{
            return redirect()->back()->with('merah','Something Wrong!');
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
        if(User::destroy($id)){
            return redirect()->back()->with('hijau','Data user berhasil dihapus!');
        }else{
            return redirect()->back()->with('merah','Oops! Ada masalah saat proses hapus data, silahkan ulangi');
        }
    }
}
