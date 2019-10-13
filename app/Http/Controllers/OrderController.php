<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Produk;
use App\Penjualan;
use App\OrderTemp;
use App\ordered_item;
use App\Pembayaran;
use App\Produksi;
use App\bahan_baku;
use \Auth, \Input, \Session;
use DataTables;
use Carbon\Carbon;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::orderBy('id', 'desc')->get();
        $penjualan = Penjualan::orderBy('id', 'desc')->first();
        $table = "penjualans";
        $primary = "id";
        $prefix = "ORD";
        $primaryfaktur = "no_faktur";
        $prefixfaktur = "FAK";
        $kodeorder = OrderController::autonumber($table, $primary, $prefix);
        $kodefaktur = OrderController::autonumberfaktur($table, $primaryfaktur, $prefixfaktur);
        return view('back.order.index', ['kodeorder' => $kodeorder, 'kodefaktur' => $kodefaktur])
            ->with('produk', $produk)
            ->with('penjualan', $penjualan);
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
        //validation
        $rules = [
            'no_faktur' => 'unique:penjualans',
            'name' => 'required|max:50',
            'tanggal_selesai' => 'required',
            'no_telfon' => 'numeric'

        ];
        $messages = [
            'name.required' => 'Nama Pemesan tidak boleh kosong',
            'name.max' => 'Nama pemesan maksimal 50 karakter',
            'tanggal_selesai.required' => 'Field Tanggal selesai tidak boleh kosong',
            'no_telfon.numeric' => ' No. Telfon harus berisikan angka'
        ];
        $request->validate($rules,$messages);
        //init
        $penjualan = new Penjualan;
        //Mutator
        $tanggalOrder = $request->tanggal_order;
        $tanggalDataOrder = date('Y-m-d', strtotime($tanggalOrder));
        $tanggalSelesai = $request->tanggal_selesai;
        $tanggalDataSelesai = date('Y-m-d', strtotime($tanggalSelesai));

        //save penjualan
        $penjualan->no_faktur = Input::get('no_faktur');
        $penjualan->name = $request->name;
        $penjualan->tanggal_order = $tanggalDataOrder;
        $penjualan->tanggal_selesai = $tanggalDataSelesai;
        $penjualan->no_telfon = $request->no_telfon;
        if ($request->payment_type == 'Lunas'){
            $penjualan->status = 1;
        }else{
            $penjualan->status = 0;
        }
        $penjualan->save();
        //save detail
        $orderItem = OrderTemp::all();
        foreach ($orderItem as $value) {
            $orderItemData = new ordered_item;
            $orderItemData->id_order = $penjualan->id;
            $orderItemData->id_produk = $value->id_produk;
            $orderItemData->harga = $value->harga;
            $orderItemData->jumlah = $value->jumlah;
            $orderItemData->sisi_cetak = $request->sisi_cetak;
            $orderItemData->proses = '0';
            $orderItemData->save();

            //save produksi

            $kodeproduksi = OrderController::autonumberproduksi();
            $produksi = new Produksi;
            $produksi->kode_produksi = $kodeproduksi;
            $produksi->id_item = $orderItemData->id;
            $produksi->desc = $request->desc;
            $produksi->id_bahan_baku = $orderItemData->produk->id_bahanbaku;
            $produksi->id_ukuran = $orderItemData->produk->id_ukuran;
            $produksi->status = 'tidak ada status';
            $produksi->save();
        }
        //save pembayaran
        if ($request->payment_type == "DP"){
            $pembayaran = new Pembayaran;
            $pembayaran->id_order = $penjualan->id;
            $pembayaran->tipe_pembayaran = $request->payment_type;
            $pembayaran->uang_masuk = $request->uang_masuk;
            $pembayaran->sisa_pembayaran = Input::get('sisa_pembayaran');
            $pembayaran->total_pembayaran = $request->total_pembayaran;
            $pembayaran->save();
        }else{
            $pembayaran = new Pembayaran;
            $pembayaran->id_order = $penjualan->id;
            $pembayaran->tipe_pembayaran = $request->payment_type;
            $pembayaran->uang_masuk = $request->uang_masuk2;
            $pembayaran->sisa_pembayaran = Input::get('sisa_pembayaran2');
            $pembayaran->total_pembayaran = $request->total_pembayaran;
            $pembayaran->save();
        }


        OrderTemp::truncate();



        return view('back.order.faktur')
            ->with('penjualan', $penjualan)
            ->with('pembayaran', $pembayaran)
            ->with('orderItem', $orderItem);
    }

    public function list()
    {
        return view('back.order.list');
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

    public function select2(Request $request)
    {
        return Order::where('no_faktur', 'LIKE', '%' . request('q') . '%')->paginate(10);
    }
    public function autonumber()
    {
        $count = ordered_item::all()->count();
        if ( $count == 0){
            return 'ORD-1';
        }else{
            $count = $count + 1;
            return 'ORD-' . $count;
        }
    }
    public function autonumberproduksi()
    {
        $count = Produksi::all()->count();
        if ( $count == 0){
            return 'PRDKS-1';
        }else{
            $count = $count + 1;
            return 'PRDKS-' . $count;
        }
    }
    public function autonumberfaktur($table, $primaryfaktur, $prefixfaktur)
    {
        $count = ordered_item::all()->count();
        if ( $count == 0){
            return 'FAK-1';
        }else{
            $count = $count + 1;
            return 'FAK-' . $count;
        }
    }
    public function dataTable()
    {
        $tanggalawal = Input::get('from');
        $tanggalakhir = Input::get('to');
        $from = date('Y-m-d', strtotime($tanggalawal));
        $to = date('Y-m-d', strtotime($tanggalakhir));
        $bb = Penjualan::join('ordered_items','penjualans.id','=','ordered_items.id_order')
                        ->join('pembayarans','penjualans.id','=','pembayarans.id_order')
                        ->join('produks','ordered_items.id_produk','=','produks.id')
                        ->join('produksis','ordered_items.id','=','produksis.id_item')
                        ->select(DB::raw('*,produks.nama as nama_produk'))
                        ->between($from,$to);
        return DataTables::of($bb)
            ->addColumn('action', function ($data) {
                return '<td>
            <button data-id="' . $data->id . '" class="btn btn-xs btn-icon btn-warning btn-round"><i class="icon wb-search" aria-hidden="true"></i></button>
                    </td>
                    ';
            })
            ->addIndexColumn()
            ->make();
    }

    public function dtDetail(Request $request)
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
    public function dtDetailPayment(Request $request)
    {
        $id = $request->id;
        $bb = Pembayaran::where('id_order', '=', $id)->get();
        return DataTables::of($bb)
            ->addIndexColumn()
            ->make();
    }

}
