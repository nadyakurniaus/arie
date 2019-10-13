<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
Use App\Pembayaran;
use App\Penjualan;
use App\ordered_item;
use Session;
use Storage;
use DataTables;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back.finance.index');
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
        $pembayaran = Penjualan::find($id);
        $detail = ordered_item::where('id_order', '=', $id)->get();
        $penjualan = Pembayaran::where('id_order', '=',$id)->first();
        $route = 'pembayaran.update';
        return view('back.finance.edit',compact('pembayaran','route','detail','penjualan'));
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
        $pembayaran = Pembayaran::where('id_order','=',$id)->first();
        $data = $pembayaran->id_order;
        $penjualan = Penjualan::find($data);
        $pembayaran2 = new Pembayaran;
        $pembayaran2->id_order = $pembayaran->id_order;
        $pembayaran2->uang_masuk = $request->bayar;
        $pembayarantemp = $pembayaran->sisa_pembayaran;
        if($pembayaran2->uang_masuk - $pembayaran->sisa_pembayaran = 0 ){
            $pembayaran2->sisa_pembayaran = 0.00;
            $pembayaran2->total_pembayaran = $pembayarantemp;
            $pembayaran2->tipe_pembayaran = 'Lunas';
            $penjualan->status = 1;
        }else{
            $pembayaran2->sisa_pembayaran = ($pembayaran->sisa_pembayaran) - ($pembayaran2->uang_masuk);
            $pembayaran2->total_pembayaran = $pembayaran->sisa_pembayaran;
            $pembayaran2->tipe_pembayaran = 'DP';
            $penjualan->status = 0;
        }
        $pembayaran->update(['tipe_pembayaran' => 'Lunas']);
        $pembayaran->save();
        $pembayaran2->save();
        $penjualan->save();
        return redirect()->route('pembayaran.index')->with('message','Pembayaran Berhasil Tersimpan!');
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
        $bb = Penjualan::all();

        return DataTables::of($bb)
            ->addColumn('action', function ($data) {
                if ($data->status != 1){
                return '<td>
                <a href="' . route('pembayaran.edit', $data->id) . '" class="btn btn-xs btn-icon btn-primary btn-round"><i class="icon wb-plus" aria-hidden="true"></i></a>
                    </td>
                    ';
                }else {
                    return '<a href="' . route('pembayaran.faktur', $data->id) . '" class="btn btn-xs btn-icon btn-primary btn-round"><i class="icon wb-print" aria-hidden="true"></i></a>';
                }
            })
            ->addIndexColumn()
            ->make();
    }
    public function dataTable2()
    {
        $bb = Penjualan::where('status', '=', '0')->get();

        return DataTables::of($bb)
            ->addColumn('action', function ($data) {
                if ($data->status != 1){
                return '<td>
                <a href="' . route('pembayaran.edit', $data->id) . '" class="btn btn-xs btn-icon btn-primary btn-round"><i class="icon wb-plus" aria-hidden="true"></i></a>
                    </td>
                    ';
                }else {
                    return '<a href="' . route('pembayaran.faktur', $data->id) . '" class="btn btn-xs btn-icon btn-primary btn-round"><i class="icon wb-print" aria-hidden="true"></i></a>';
                }
            })
            ->addIndexColumn()
            ->make();
    }

    public function dataTableDetail(Request $request)
    {
        $id = $request->id;
        $bb = ordered_item::where('id_order', '=', $id)->get();
        return DataTables::of($bb)
            ->addIndexColumn()
            ->addColumn('nama_produk', function ($data) {
                return $data->produk->nama;
            })->addColumn('idProduk', function ($data) {
                return $data->produk->idProduk;
            })
            ->make();
    }
    public function dataTableDetailPayment(Request $request)
    {
        $id = $request->id;
        $bb = Pembayaran::where('id_order', '=', $id)->get();
        return DataTables::of($bb)
            ->addIndexColumn()
            ->make();
    }
    public function faktur($id){
        $item = Penjualan::join('ordered_items','ordered_items.id_order','=','penjualans.id')
        ->where('penjualans.id','=', $id)
        ->first();
        $data = Pembayaran::join('penjualans','penjualans.id','=','pembayarans.id_order')
        ->join('ordered_items','ordered_items.id_order','=','penjualans.id')
        ->join('produks','produks.id','=','ordered_items.id_produk')
        ->join('bahan_bakus','bahan_bakus.id','=','produks.id_bahanbaku')
        ->join('ukuran_bahans','ukuran_bahans.id','=','produks.id_ukuran')
        ->select(DB::raw('*,ukuran_bahans.nama as namaukuran,bahan_bakus.nama as bahanbaku,produks.nama as namaproduk'))
        ->limit(1)
        ->get();
        return view ('back.finance.faktur', compact('item','data'));
    }
}
