<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Produksi;
use App\pengambilanbarang;
use App\Penjualan;
use App\ordered_item;

class PengambilanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = new pengambilanbarang;
        return view('back.admin.pengambilan', compact('data'));
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
    public function faktur($id)
    {
        $penjualan = Penjualan::find($id);
        $item = ordered_item::join('produksis','ordered_items.id','=','produksis.id_item')
        ->join('produks','ordered_items.id_produk','=','produks.id')
        ->join('bahan_bakus','produks.id_bahanbaku','=','bahan_bakus.id')
        ->join('ukuran_bahans','produks.id_ukuran','=','ukuran_bahans.id')
        ->where('ordered_items.id','=', $id)
        ->select(DB::raw('*,ukuran_bahans.nama as namaukuran,bahan_bakus.nama as bahanbaku,produks.nama as namaproduk'))->get();
        return view ('back.admin.fakturpengambilan', compact('penjualan','item'));
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
        $item = ordered_item::join('produksis', 'produksis.id_item', '=', 'ordered_items.id')
            ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
            ->join('pembayarans', 'pembayarans.id_order', '=', 'penjualans.id')
            ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
            ->join('bahan_bakus', 'produks.id_bahanbaku', '=', 'bahan_bakus.id')
            ->join('ukuran_bahans', 'produks.id_ukuran', '=', 'ukuran_bahans.id')
            ->join('pengambilanbarangs','pengambilanbarangs.id_order' , '=', 'produksis.id','left')
            ->where('ordered_items.id', '=', $id)
            ->select(DB::raw('*,bahan_bakus.nama as bahanbaku,produks.nama as namaproduk,produksis.id as id_prod,ukuran_bahans.id as ukuran'))->first();
        $data['no_faktur'] = $item->no_faktur;
        $data['nama_pemesan'] = $item->name;
        $data['namaproduk'] = $item->namaproduk;
        $data['desc'] = $item->desc;
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
        $produksi = ordered_item::find($id);
        $produksi->proses = 6;
        $produksi->save();
        $pengambilan = new pengambilanbarang;
        $pengambilan->id_order = $produksi->penjualan->id;
        $pengambilan->nama_penerima = $request->nama_pengambil;
        $pengambilan->save();

        return redirect()->back()->with('message','Pengambilan Sukses!');
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
    public function dtpengambilan()
    {
        $bb = ordered_item::join('produksis', 'produksis.id_item', '=', 'ordered_items.id')
            ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
            ->join('pembayarans', 'pembayarans.id_order', '=', 'penjualans.id')
            ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
            ->join('bahan_bakus', 'produks.id_bahanbaku', '=', 'bahan_bakus.id')
            ->join('ukuran_bahans', 'produks.id_ukuran', '=', 'ukuran_bahans.id')
            ->join('pengambilanbarangs','pengambilanbarangs.id_order' , '=', 'produksis.id','left')
            ->where('ordered_items.proses', '>=', '5')
            ->where('penjualans.status', '>', '0')
            ->select(DB::raw('*,bahan_bakus.nama as bahanbaku,produks.nama as namaproduk,produksis.id as id_prod,ukuran_bahans.nama as ukuran,ordered_items.created_at as ca'))
            ->orderBy('ordered_items.id','desc')
            ->get();
            return DataTables::of($bb)
            ->addColumn('status_penerimaan', function ($data) {
                if ($data->proses == 5){
                    return 'Belum diambil';
                }else if ($data->proses == 6){
                    return $data->nama_penerima;
                }
            })
            ->addColumn('action', function () {
                return '';
            })
            ->addIndexColumn()
            ->make();
    }
    public function autonumber(){
        $count = pengambilanbarang::all()->count();
        if ( $count == 0){
            return 'PNG-1';
        }else{
            $count = $count + 1;
            return 'PNG-' . $count;
        }
    }
}
