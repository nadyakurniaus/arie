<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UkuranBahan;
Use App\bahan_baku;
use Session;
use Storage;
use DataTables;

class UkuranbahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back.gudang.ukuranbahan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.gudang.ukuranbahan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nama' => 'required',
            'bahan_id'=>'required',
            'stok' => 'required|numeric',
            'satuan' => 'required'
            
        ];
        $messages = [
            'nama.required' => 'Ukuran bahan tidak boleh kosong',
            'bahan_id.required' => 'Bahan baku tidak boleh kosong',
            'stok.required' => ':attribute tidak boleh kosong',
            'stok.numeric' => ':attribute harus berisikan angka',
            'satuan.required' => ':attribute tidak boleh kosong',
        ];
        $request->validate($rules,$messages);

        $bahan = new UkuranBahan;
        $bahan->nama = $request->nama;
        $bahan->id_bahanbaku = $request->bahan_id;
        $bahan->stok = $request->stok;
        $bahan->satuan = $request->satuan;
        $bahan->save();
        //toastr notification
        $notif = array(
            'message' => 'Data ukuran berhasil tersimpan!',
            'alert-type' => 'info',
        );
        return redirect()->route('ukuranbahan.index')->with($notif);
        
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
    }
    public function dataTable()
    {
        $bb = UkuranBahan::all();
        return DataTables::of($bb)
        ->addColumn('action',function($data)
        {
            return '<td>
            <a href="' . route('ukuranbahan.edit', $data->id) .'" class="btn btn-xs btn-icon btn-warning btn-round"><i class="icon wb-edit" aria-hidden="true"></i></a>
                        <button type="button" data-toggle="modal" data-target="#delete-modal" data-id="' . $data->id . '" data-name="' . $data->name . '" class="btn btn-xs btn-icon btn-danger btn-delete btn-round"><i class="icon wb-trash" aria-hidden="true"></i></button>
                    </td>
                    ';
                })
                ->addColumn('bahan',function($data){
                    return $data->bahan->nama;
                })
                ->addIndexColumn()
                ->make();
    }
    public function select2(Request $request)
    {
        return bahan_baku::where('nama','LIKE','%' . request('q') . '%')->paginate(10);
    }
}
