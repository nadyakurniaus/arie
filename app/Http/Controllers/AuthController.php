<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\User;
use Auth;
use App\Pembelian;
use App\Produk;
use App\bahan_baku;
use App\Penjualan;
use App\Design;
use App\Produksi;

class AuthController extends Controller
{

    public function login(Request $request)
    {

        // \Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        //Error messages
        $messages = [
            "password.required" => "Password is required",
        ];

        // validate the form data
        $validator = Validator::make($request->all(), [
            'password' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return view()->route('auth.login')->withError('message','login gagal!');
        } else {
            // attempt to log
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
                if (Auth::user()->role == 'admin' and Auth::user()->status == 1) {
                    $data = Produk::select(DB::raw('count(*) as x'))
                    ->get();
                    $bahan = bahan_baku::select(DB::raw('count(*) as x'))
                    ->get();
                    $order = Penjualan::select(DB::raw('count(*) as x'))
                    ->get();
                    return redirect()
                    ->route('index.admin')
                    ->with('data', $data)
                    ->with('bahan', $bahan)
                    ->with('order', $order)
                    ->with('message', 'Anda login sebagai ' . Auth::user()->role );
                }
                if (Auth::user()->role == 'finance' and Auth::user()->status == 1) {
                    $penjualancount = Penjualan::select(DB::raw('count(*) as x'))
                        ->where('status', '=', 0)
                        ->get();
                    return redirect()
                    ->route('index.finance')
                    ->with('penjualancount',$penjualancount)
                    ->with('message', 'Anda login sebagai ' . Auth::user()->role);
                }
                if (Auth::user()->role == 'gudang' and Auth::user()->status == 1) {
                    $bbcount = bahan_baku::select(DB::raw('count(*) as x'))
                        ->get();
                        $bbcount = $bbcount->toArray();
                    return redirect()
                    ->route('index.gudang')
                    ->with('bbcount',$bbcount)
                    ->with('message', 'Anda login sebagai ' . Auth::user()->role);
                }
                if (Auth::user()->role == 'setting' and Auth::user()->status == 1) {
                    $settingcount = Design::select(DB::raw('count(*) as x'))
                        ->get();
                    return redirect()
                    ->route('index.setting')
                    ->with('settingcount',$settingcount)
                    ->with('message', 'Anda login sebagai ' . Auth::user()->role);
                }
                if (Auth::user()->role == 'supervisor' and Auth::user()->status == 1) {
                    $produksicount = Produksi::select(DB::raw('count(*) as x'))
                        ->where('jadwal_produksi', '=', null)
                        ->get();
                    return redirect()
                    ->route('index.supervisor')
                    ->with('produksicount',$produksicount)
                    ->with('message', 'Anda login sebagai ' . Auth::user()->role);
                }
                if (Auth::user()->role == 'manajer' and Auth::user()->status == 1) {
                    $JPPBB = Pembelian::select(DB::raw('count(*) as x'))
                        ->where('status', '=', 'on process')
                        ->get();
                    return redirect()
                    ->route('index.manajer')
                    ->with('JPPBB',$JPPBB)
                    ->with('message', 'Anda login sebagai ' . Auth::user()->role);
                }
                if(Auth::user()->role == 'adminsystem' and Auth::user()->status == 1){
                    $usercount = User::select(DB::raw('count(*) as x'))
                        ->get();
                    return redirect()
                    ->route('index.AdminSys')
                    ->with('usercount',$usercount)
                    ->with('message', 'Anda login sebagai ' . Auth::user()->role);
                }
                if(Auth::user()->role == 'direktur' and Auth::user()->status == 1){
                    return redirect()
                    ->route('direktur')
                    ->with('message', 'Anda login sebagai ' . Auth::user()->role);
                }
                if(Auth::user()->role == 'cutting' and Auth::user()->status == 1){
                    return redirect()
                    ->route('index.cutting')
                    ->with('message', 'Anda login sebagai ' . Auth::user()->role);
                }
                if(Auth::user()->role == 'offset' and Auth::user()->status == 1){
                    return redirect()
                    ->route('index.printing')
                    ->with('message', 'Anda login sebagai ' . Auth::user()->role);
                }
                if(Auth::user()->role == 'finishing' and Auth::user()->status == 1){
                    return redirect()
                    ->route('index.finishing')
                    ->with('message', 'Anda login sebagai ' . Auth::user()->role);
                }
            }

            // if unsuccessful -> redirect back
            return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors([])->with('message', 'Username / Password salah!');
        }
        //dd(Auth::user()->role);

    }
    public function logout()
    {
        \Auth::logout();

        return redirect()->route('/');
    }
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'role' => 'required',
        ];
        $messages = [
            'name.required' => ':attribute tidak boleh kosong',
            'username.required' => ':attribute tidak boleh kosong',
            'username.unique' => 'username telah terpakai',
            'email.required' => ':attribute tidak boleh kosong',
            'email.unique' => 'email telah terpakai',
            'role.required' => ':attribute tidak boleh kosong',
        ];
        $request->validate($rules, $messages);


        $user = new User;
        $user->idUser = $request->idUser;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $autopw = hash::make('percetakanarie');
        $user->password = $autopw;
        $user->role = $request->role;

        $user->save();

        return redirect()->route('user.index')->with('message','Pengguna Berhasil ditambahkan!');
    }
    public function getRegister()
    {
        return view('auth.register');
    }
}
