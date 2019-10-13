<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\User;
use Session;
use DataTables;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back.admin.kelolauser');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $table = "users";
        $primary = "id";
        $prefix = "USR";
        $kodeuser = UserController::autonumber();

        return view('back.admin.createuser', ['kodeuser' => $kodeuser]);
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
        $user = User::find($id);
        $data['idUser'] = $user->idUser;
        $data['name'] = $user->name;
        $data['username'] = $user->username;
        $data['email'] = $user->email;
        echo json_encode($data);
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
        if ( $request->pwbaru == $request->cnfrmpwbaru){
        $user = User::find($id);
        $newpw = Hash::make($request->pwbaru);
        $user->password = $newpw ;
        $user->save();
        return redirect()->back()->with('message','Password berhasil diubah!');
        }else{

        return redirect()->back()->with('message','Request password tidak sama, harap coba kembali!');
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
        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with('message','Pengguna berhasil dihapus!');

    }
    public function dataTable()
    {
        $user = User::all();
        return DataTables::of($user)
        ->addColumn('action',function($data)
        {
            if ($data->role != 'adminsystem'){
                return '<td>
                <a href="' . route('user.updatestatus', $data->id) .'" class="btn btn-xs btn-icon btn-warning btn-round"><i class="icon wb-edit" aria-hidden="true"></i></a>
                <button type="button" data-toggle="modal" data-target="#delete-modal" data-id="' .$data->id . '"  class="btn btn-xs btn-icon btn-danger btn-delete btn-round"><i class="icon wb-trash" aria-hidden="true"></i></button>
                        </td>
                        ';
            }else{
              return  '';
            }

                })
                ->addIndexColumn()
                ->make();
    }
    public function autonumber()
    {
        $count = User::all()->count();
        if ( $count == 0){
            return 'USR-1';
        }else{
            $count = $count + 1;
            return 'USR-' . $count;
        }
    }
    public function updateStatus($id){
        $user = User::find($id);
        if($user->status != '1'){
            $user->status = '1';
            $user->save();

            return redirect()->back()->with('message','Status Pengguna berhasil diubah!');
        }else{
            $user->status = '0';
            $user->save();

            return redirect()->back()->with('message','Status Pengguna berhasil diubah!');
        }
        $user->delete();

        return redirect()->back()->with('message','Status Pengguna berhasil diubah!');
    }
}
