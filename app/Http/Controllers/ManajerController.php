<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;

use Storage;
use DataTables;
use App\Design;
use App\Pembelian;
use App\Pembelian_detail;
use Image;
use App\UkuranBahan;

class ManajerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $counter = Pembelian::select(DB::raw('count(*) as jumlah_permintaan'))
            ->where('status','=','on process')
            ->get();
        return view('back.manajer.index',['JPPBB' => $counter]);
        // return view('back.manajer.index');
    }
    public function listview()
    {
        $pem = Pembelian::where('status', '=', 'on process')->get();
        $pembcount = $pem->count();
        $counter = Pembelian::select(DB::raw('count(*) as jumlah_permintaan'))
        ->where('status','=','on process')
        ->get();
        return view('back.manajer.permintaan',['JPPBB' => $counter])->with('pembcount', $pembcount);

    }
    public function listview2()
    {
        $pem = Pembelian::where('status', '=', 'on process')->get();
        $pembcount = $pem->count();
        $counter = Pembelian::select(DB::raw('count(*) as jumlah_permintaan'))
        ->where('status','=','on process')
        ->get();
        return view('back.manajer.permintaan2',['JPPBB' => $counter])->with('pembcount', $pembcount);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $design = Produksi::find($id);
        $bb = Produksi::join('designs', 'produksis.id', '=', 'designs.id_produksi', 'left')
            ->join('penjualans', 'produksis.id_order', '=', 'penjualans.id')
            ->join('ordered_items', 'ordered_items.id_order', '=', 'penjualans.id')
            ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
            ->select(DB::raw('*,produksis.kode_produksi as kp,produks.nama as namaproduk'))
            ->first();
        $route = 'setting.update';
        return view('back.bagsetting.update', compact('design', 'route', 'bb'));
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
        $designnama = $request->design_old;
        if ($request->hasFile('design')) {
            $designnama = $this->uploadDesign($request, $designnama);
        }
        $produksi = Produksi::find($id);
        $produksi->proses = '1';
        $produksi->save();
        $designed = new Design;
        $designed->id_produksi = $produksi->id;
        $designed->design = $designnama;
        $designed->save();

        return view('back.bagsetting.index')
            ->with('message', 'Design berhasil tersimpan!');
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
    public function approve(Request $request)
    {
        $id = $request->input('id');
        $pem = Pembelian::join('pembelian_details','pembelians.id','=', 'pembelian_details.id_pembelian')
        ->where('pembelians.id','=',$id)
        ->first();
        $id2 = $pem->id_bahanbaku;
        $bahan = Ukuranbahan::where('id_bahanbaku', '=', $id2)->first();
        $stok = $bahan->stok;
        $qty = $pem->qty;
        $status = $request->input('status');
        $table = new Pembelian();
        $table2 = new UkuranBahan();
        $table2::where('id', $id2)->update(['stok' => $stok + $qty]);
        $table::where('id', $id)
            ->update(['status' => $status]);

        return response()->json([
            'title' => 'Success',
            'message' => 'Data anda tersimpan kedalam sistem!',
            'type'    => 'success',
        ]);
    }

    public function dataTable()
    {
        $bb = Pembelian::join('pembelian_details', 'pembelians.id', '=', 'pembelian_details.id_pembelian')
            ->join('bahan_bakus', 'bahan_bakus.id', '=', 'pembelian_details.id_bahanbaku')
            ->join('ukuran_bahans', 'ukuran_bahans.id', '=', 'pembelian_details.id_ukuran')
            ->select(DB::raw('*,pembelians.id as id_pembelian,bahan_bakus.nama as bahan,ukuran_bahans.nama as ukuran'))
            ->orderBy('pembelians.id','desc')
            ->get();
        return DataTables::of($bb)
            ->addIndexColumn()
            ->make();
    }
    public function dataTable2()
    {
        $bb = Pembelian::join('pembelian_details', 'pembelians.id', '=', 'pembelian_details.id_pembelian')
            ->join('bahan_bakus', 'bahan_bakus.id', '=', 'pembelian_details.id_bahanbaku')
            ->join('ukuran_bahans', 'ukuran_bahans.id', '=', 'pembelian_details.id_ukuran')
            ->where('status', '=', 'on process')
            ->select(DB::raw('*,pembelians.id as id_pembelian,bahan_bakus.nama as bahan,ukuran_bahans.nama as ukuran'))
            ->orderBy('pembelians.id','desc')
            ->get();
        return DataTables::of($bb)
            ->addIndexColumn()
            ->make();
    }
}
