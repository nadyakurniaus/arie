<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\bahan_baku;
use App\Monitoring;
use App\Produk;
use App\Harga;
use App\Penjualan;
use App\Pembayaran;
use App\ordered_item;
use App\Pembelian;
use App\User;
use App\Produksi;

class AdminController extends Controller
{
    public function dataTable(){
        $bb = bahan_baku::join('monitorings', 'bahan_bakus.id', '=', 'monitorings.id','left')
        ->join('ukuran_bahans', 'bahan_bakus.id', '=', 'ukuran_bahans.id_bahanbaku')
        ->select(DB::raw('*,bahan_bakus.nama as bahanbaku,ukuran_bahans.nama as namaukuran'))->get();
        return DataTables::of($bb)
            ->addColumn('keterangan', function($data){
                if ($data->stok > $data->minimum){
                    return '<td class="text-xs-center"><span class="tag tag-pill tag-success">Tersedia!</span></td>';
                }else{
                    return '<span class="tag tag-pill tag-danger">Restock!</span>';
                }

            })
            ->rawColumns(['keterangan','action'])
            ->addIndexColumn()
            ->make();
    }
    public function lappricelist(){
        $data1 = Produk::join('hargas','hargas.id_produk','=','produks.id')
        ->where('jenis_cetak','=','Offset')
        ->select(DB::raw('*,produks.nama as namaprod'))
        ->get();
        $data2 = Produk::join('hargas','hargas.id_produk','=','produks.id')
        ->where('jenis_cetak','=','Digital Printing')->get();

        return view('bbpdf')
        ->with('data1',$data1)
        ->with('data2',$data2);
    }
    public function dataTablePriceList()
    {
        $bb = Produk::join('hargas','hargas.id_produk','=','produks.id')
        ->where('jenis_cetak','=','Offset')->get();
        return DataTables::of($bb)
            ->addColumn('action', function ($data) {
                return '<td>
            <a href="' . route('product.edit', $data->id) . '" class="btn btn-xs btn-icon btn-warning btn-round"><i class="icon wb-edit" aria-hidden="true"></i></a>
            <button data-id="' . $data->id . '" class="btn btn-xs btn-icon btn-primary btn-round"><i class="icon wb-plus" aria-hidden="true"></i></button>
                    </td>
                    ';
            })
            ->addColumn('ukuran', function ($data) {
                return $data->ukuran->nama;
            })
            ->addColumn('bahan', function ($data) {
                return $data->ukuran->bahan->nama;
            })
            ->addIndexColumn()
            ->make();
    }
    public function dataTablePriceList2()
    {
        $bb = Produk::join('hargas','hargas.id_produk','=','produks.id')
        ->where('jenis_cetak','=','Digital Printing')->get();
        return DataTables::of($bb)
            ->addColumn('action', function ($data) {
                return '<td>
            <a href="' . route('product.edit', $data->id) . '" class="btn btn-xs btn-icon btn-warning btn-round"><i class="icon wb-edit" aria-hidden="true"></i></a>
            <button data-id="' . $data->id . '" class="btn btn-xs btn-icon btn-primary btn-round"><i class="icon wb-plus" aria-hidden="true"></i></button>
                    </td>
                    ';
            })
            ->addColumn('ukuran', function ($data) {
                return $data->ukuran->nama;
            })
            ->addColumn('bahan', function ($data) {
                return $data->ukuran->bahan->nama;
            })
            ->addIndexColumn()
            ->make();
    }
    public function dataTableDetail(Request $request)
    {
        $id = $request->id;
        $bb = Harga::where('id_produk', '=', $id)->get();
        return DataTables::of($bb)
            ->addIndexColumn()
            ->make();
    }
    public function dataTableDetail2(Request $request)
    {
        $id = $request->id;
        $bb = Harga::where('id_produk', '=', $id)->get();
        return DataTables::of($bb)
            ->addIndexColumn()
            ->make();
    }



    public function indexGudang(){
        $bbcount = bahan_baku::get()->count();
        $count = bahan_baku::join('ukuran_bahans', 'bahan_bakus.id' , '=', 'ukuran_bahans.id_bahanbaku')
        ->join('monitorings', 'bahan_bakus.id', '=', 'monitorings.id_bahanbaku','left')
        ->whereColumn('stok', '<=', 'minimum')
        ->get();
        $counter = $count->count();
        return view('back.dashboard-gudang')->with('bbcount',$bbcount)->with('counter', $counter);
    }
    public function indexAdmin(){
        $bbcount = bahan_baku::get()->count();
        $prodcount = Produk::get()->count();
        $penjcount = Penjualan::get()->count();
        return view('back.dashboard')->with('bbcount',$bbcount)->with('prodcount',$prodcount)->with('penjcount',$penjcount);
    }
    public function indexFinance(){
        $pembayaran = Pembayaran::where('tipe_pembayaran', '<=', 'DP')->get();
        $pemcount = $pembayaran->count();
        return view('back.dashboard-finance')->with('pemcount',$pemcount);
    }
    public function WidgetFinance(){
        $pembayaran = Pembayaran::where('tipe_pembayaran', '<=', 'DP')->get();
        $pemcount = $pembayaran->count();
        return view('back.finance.widgetfinance')->with('pemcount',$pemcount);
    }
    public function indexSetting(){
       $bb = ordered_item::join('designs', 'ordered_items.id', '=', 'designs.id_ordered','left')
        ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
        ->join('produksis', 'ordered_items.id_order', '=', 'produksis.id')
        ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
        ->where('design','=',NULL)
        ->get();
        $designcount = $bb->count();
        return view('back.dashboard-setting')->with('designcount', $designcount);
    }
    public function SettingWidget(){
        $bb = ordered_item::join('designs', 'ordered_items.id', '=', 'designs.id_ordered','left')
        ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
        ->join('produksis', 'ordered_items.id_order', '=', 'produksis.id')
        ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
        ->where('design','=',NULL)
        ->get();
        $designcount = $bb->count();
        return view('back.bagsetting.detail-widget')->with('designcount', $designcount);
    }
    public function indexManajer(){
        $pem = Pembelian::where('status', '=', 'on process')->get();
        $pembcount = $pem->count();

        return view('back.dashboard-manajer')->with('pembcount', $pembcount);
    }
    public function indexAdminSys(){
        $user = User::get()->count();

        return view('back.dashboard-adminsys')->with('user', $user);
    }
    public function indexSupervior(){
        $count = Produksi::whereNull('jadwal_produksi')
                        ->get();
        $produksicount = $count->count();
        return view('back.dashboard-supervisor')->with('produksicount', $produksicount);
    }
    public function indexCutting(){
        $produksi= ordered_item::where('proses', '=', 3)
                        ->get();
        $produksicount = $produksi->count();
        return view('back.dashboard-cutting')->with('produksicount', $produksicount);
    }
    public function WidgetCutting(){
        $produksi= ordered_item::where('proses', '=', 3)
                        ->get();
        $produksicount = $produksi->count();
        return view('back.cutting.widget')->with('produksicount', $produksicount);
    }
    public function indexPrinting(){
        $produksi= ordered_item::where('proses', '=', 2)
                        ->get();
        $produksicount = $produksi->count();
        return view('back.dashboard-printing')->with('produksicount', $produksicount);
    }
    public function WidgetPrinting(){
        $produksi= ordered_item::where('proses', '=', 2)
                        ->get();
        $produksicount = $produksi->count();
        return view('back.layouts-printing.widget')->with('produksicount', $produksicount);
    }
    public function indexFinishing(){
        $produksi= ordered_item::where('proses', '=', 4)
                        ->get();
        $produksicount = $produksi->count();
        return view('back.dashboard-finishing')->with('produksicount', $produksicount);
    }
    public function WidgetFinishing(){
        $produksi= ordered_item::where('proses', '=', 4)
                        ->get();
        $produksicount = $produksi->count();
        return view('back.finishing.widget')->with('produksicount', $produksicount);
    }
    public function prosesFinishing(){
        return view('back.finishing.index');
    }
    public function prosesCutting(){
        return view('back.cutting.index');
    }
    public function prosesPrinting(){
        return view('back.printing.index');
    }
    public function pricelist(){
        $data1 = Produk::join('hargas','hargas.id_produk','=','produks.id')
        ->where('jenis_cetak','=','Offset')
        ->select(DB::raw('*,produks.nama as namaprod'))
        ->get();
        $data2 = Produk::join('hargas','hargas.id_produk','=','produks.id')
        ->where('jenis_cetak','=','Digital Printing')->get();

        return view('bbpdf2')
        ->with('data1',$data1)
        ->with('data2',$data2);
    }
}
