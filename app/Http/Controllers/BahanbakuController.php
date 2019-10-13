<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

use App\Bahan_baku;
use App\UkuranBahan;
use DataTables;

use Session;
use Storage;
use PDF;

class BahanbakuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bbcount = bahan_baku::get()->count();
        $count = bahan_baku::join('ukuran_bahans', 'bahan_bakus.id' , '=', 'ukuran_bahans.id_bahanbaku')
        ->join('monitorings', 'bahan_bakus.id', '=', 'monitorings.id_bahanbaku','left')
        ->whereColumn('stok', '<=', 'minimum')
        ->get();
        $counter = $count->count();

        return view('back.gudang.bahanbaku.index')->with('counter', $counter);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $count = bahan_baku::join('ukuran_bahans', 'bahan_bakus.id' , '=', 'ukuran_bahans.id_bahanbaku')
        ->join('monitorings', 'bahan_bakus.id', '=', 'monitorings.id_bahanbaku','left')
        ->where('stok', '<=', 'minimum')
        ->get();
        $counter = $count->count();
        $table = "bahan_bakus";
        $primary = "id";
        $prefix = "BB";
        $tableukuran = "ukuran_bahans";
        $primaryukuran = "id";
        $prefixukuran = "UKR";
        $kodebahan = BahanbakuController::autonumber();
        $kodeukuran = BahanbakuController::idUkuran();
        return view('back.gudang.bahanbaku.create', ['kodebahan' => $kodebahan, 'kodeukuran' => $kodeukuran, 'counter' => $counter]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bahan = bahan_baku::where('nama', '=',$request->nama)
        ->where('namaukuran' ,'=', $request->namaukuran)->first();
        if ( $bahan === null) {
            $rules = [
                'nama' => 'required',
                'jenis' => 'required',
                'namaukuran' => 'required',
                'stok' => 'required|numeric',
                'satuan' => 'required'

            ];
            $messages = [
                'nama.required' => 'Nama Bahan Baku tidak boleh kosong',
                'nama.unique' => 'Nama Bahan Baku telah terdaftar pada database',
                'jenis.required' => ':attribute tidak boleh kosong',
                'namaukuran.required' => 'Ukuran bahan tidak boleh kosong',
                'stok.required' => ':attribute tidak boleh kosong',
                'stok.numeric' => ':attribute harus berisikan angka',
                'satuan.required' => ':attribute tidak boleh kosong',

            ];
            $request->validate($rules,$messages);
            //Save Bahan Baku
            $bahan = new Bahan_baku;
            $bahan->idBB = $request->idBB;
            $bahan->nama = $request->nama;
            $bahan->namaukuran = $request->namaukuran;
            $bahan->jenis = $request->jenis;
            $bahan->save();
            //Save Ukuran bahan
            $ukuran = new UkuranBahan;
            $ukuran->idukuran = $request->idUkuran;
            $ukuran->nama = $request->namaukuran;
            $ukuran->id_bahanbaku = $bahan->id;
            $ukuran->stok = $request->stok;
            $ukuran->satuan = $request->satuan;
            $ukuran->save();
    
            return redirect()->route('bahanbaku.index')->with('message','Bahan Baku berhasil ditambahkan!');
        }else{
            return redirect()->back()->with('error','Data tidak bisa ditambahkan karena data telah terdaftar sebelumnya pada database!');
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
        $count = bahan_baku::join('ukuran_bahans', 'bahan_bakus.id' , '=', 'ukuran_bahans.id_bahanbaku')
        ->join('monitorings', 'bahan_bakus.id', '=', 'monitorings.id_bahanbaku','left')
        ->where('stok', '<=', 'minimum')
        ->get();
        $counter = $count->count();
        $bahan = Bahan_baku::find($id);
        $ukuran = UkuranBahan::find($id);
        $route = 'bahanbaku.update';
        return view('back.gudang.edit',compact('bahan','ukuran','route','counter'));

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
        $rules = [
            'nama' => 'required',
            'jenis' => 'required',
            'namaukuran' => 'required',
            'stok' => 'required|numeric',
            'satuan' => 'required'

        ];
        $messages = [
            'nama.required' => 'Nama Bahan Baku tidak boleh kosong',
            'jenis.required' => ':attribute tidak boleh kosong',
            'namaukuran.required' => 'Ukuran bahan tidak boleh kosong',
            'stok.required' => ':attribute tidak boleh kosong',
            'stok.numeric' => ':attribute harus berisikan angka',
            'satuan.required' => ':attribute tidak boleh kosong',

        ];
        $request->validate($rules,$messages);

        $bahan = Bahan_baku::find($id);
        $ukuran = UkuranBahan::find($id);
        $bahan->nama = $request->nama;
        $bahan->jenis = $request->jenis;
        $bahan->save();
        $ukuran->nama = $request->namaukuran;
        // $ukuran->id_bahanbaku = $request->id;
        $ukuran->stok = $request->stok;
        $ukuran->satuan = $request->satuan;
        $ukuran->save();

        return redirect()->route('bahanbaku.index')->with('message','Bahan Baku berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bahan = Bahan_baku::find($id);
        $bahan->delete();

        return redirect()->route('bahanbaku.index')->with('message','Bahan baku berhasil dihapus!');
    }
    public function dataTable()
    {
        $bb = bahan_baku::join('ukuran_bahans', 'bahan_bakus.id', '=', 'ukuran_bahans.id_bahanbaku')->select(DB::raw('*,bahan_bakus.nama as bahanbaku,ukuran_bahans.nama as namaukuran'))->get();
        return DataTables::of($bb)
        ->addColumn('minim', function(){
            return '10';
        })
        ->addColumn('action',function($data)
        {
            return '<td class="text-xs-center">
            <a href="' . route('bahanbaku.edit', $data->id) .'" class="btn btn-xs btn-icon btn-warning btn-round "><i class="icon wb-edit" aria-hidden="true"></i></a>
                    </td>
                    ';
                })
            ->addIndexColumn()
            ->make();
    }
    public function autonumber()
    {

        $count = Bahan_baku::all()->count();
        if ( $count == 0){
            return 'BB-1';
        }else{
            $count = $count + 1;
            return 'BB-' . $count;
        }

    }
    public function idUkuran()
    {
        $count = Bahan_baku::all()->count();
        if ( $count == 0){
            return 'UKR-1';
        }else{
            $count = $count + 1;
            return 'UKR-' . $count;
        }
    }

}
