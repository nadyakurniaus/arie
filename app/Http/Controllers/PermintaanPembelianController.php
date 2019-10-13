<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Produksi;
use App\Pembelian;
use App\Pembelian_detail;
use App\Pembelian_temp;
use App\Produk;
use App\Penjualan;
use App\UkuranBahan;
use App\bahan_baku;
use Session;
use Storage;
use DataTables;

class PermintaanPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Pembelian_temp::truncate();
        $produk = Produk::orderBy('id', 'desc')->first();
        $pembelian = Pembelian::orderBy('id', 'desc')->first();
        $check = Pembelian::select(DB::raw('count(*) as jumlah_permintaan'));
        $count = bahan_baku::join('ukuran_bahans', 'bahan_bakus.id' , '=', 'ukuran_bahans.id_bahanbaku')
        ->join('monitorings', 'bahan_bakus.id', '=', 'monitorings.id_bahanbaku','left')
        ->where('stok', '<=', 2)
        ->get();
        $counter = $count->count();
        return view('back.admin.pembelian.index')
            ->with('produk', $produk)
            ->with('pembelian', $pembelian)
            ->with('counter', $counter);
        // return view('back.manajer.index',['JPPBB' => $counter]);
    }


    public function addItem(Request $request)
    {
        $item_row = $request['item_row'];
        $html = view('back.admin.pembelian.item', compact('item_row', 'taxes', 'currency'))->render();

        return response()->json([
            'success' => true,
            'error'   => false,
            'message' => 'null',
            'html'    => $html,
        ]);
    }
    public function totalItem(Request $request)
    {
        $input_items = $request->input('item');
        $json = new \stdClass;
        $sub_total = 0;
        $items = array();
        if ($input_items) {
            foreach ($input_items as $key => $item) {
                $quantity = (double)$item['quantity'];
                $item_sub_total = $quantity;
                $sub_total += $item_sub_total;
                $items[$key] = $item_sub_total;
            }
        }

        $json->items = $items;
        $grand_total = $sub_total;
        $json->grand_total = $grand_total;
        // Get currency object
        return response()->json($json);
    }
    public function autocomplete()
    {
        $query = request('query');

        $autocomplete = bahan_baku::autocomplete([
            'nama' => $query,
            'jenis' => $query,
        ]);
        $items = $autocomplete->get();
        return response()->json($items);
    }

    public function HasilProduksi()
    {
        return view('back.admin.produksi.hasil');
    }
    public function JadwalProduksi()
    {
        return view('back.admin.produksi.jadwal');
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
        ->whereColumn('stok', '<=', 'minimum')
        ->get();
        $counter = $count->count();
        $kodepembelian = PermintaanPembelianController::autonumber();
        $produk = Produk::orderBy('id', 'desc')->first();
        $pembelian = Pembelian::orderBy('id', 'desc')->first();
        return view('back.admin.pembelian.create')
            ->with('produk', $produk)
            ->with('kode_pembelian', $kodepembelian)
            ->with('pembelian', $pembelian)
            ->with('counter', $counter);
    }
    public function createWith(Request $request)
    {
        $kodepembelian = PermintaanPembelianController::autonumber();
        $produk = Produk::orderBy('id', 'desc')->first();
        $pembelian = Pembelian::orderBy('id', 'desc')->first();
        return view('back.admin.pembelian.create')
            ->with('produk', $produk)
            ->with('kode_pembelian', $kodepembelian)
            ->with('pembelian', $pembelian)
            ->with('metode', $request->session()->get('metode'))
            ->with('getTanggal', $request->session()->get('tanggal_produksi'));
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
            'comments' => 'required',


        ];
        $messages = [
            'comments.required' => ':attribute tidak boleh kosong',

        ];
        $request->validate($rules, $messages);

        $permintaan = $request->input('tanggal_permintaan');
        $dataPermintaan = date('Y-m-d', strtotime($permintaan));

        $pembelian = new Pembelian;
        $pembelian->kode = $request->id_order;
        $pembelian->tanggal_produksi = $request->input('tanggal_produksi');
        $pembelian->tanggal_permintaan = $dataPermintaan;
        $pembelian->catatan = $request->input('comments');
        $pembelian->status = 'on process';
        $pembelian->save();

        $pembelianTemp = Pembelian_temp::all();
        foreach ($pembelianTemp as $value) {
            $pembelianDetail = new Pembelian_detail;
            $pembelianDetail->id_pembelian = $pembelian->id;
            $pembelianDetail->id_bahanbaku = $value->id_bahanbaku;
            $pembelianDetail->jenis = $value->jenis;
            $pembelianDetail->id_ukuran = $value->id_ukuran;
            $pembelianDetail->satuan = $value->satuan;
            $pembelianDetail->kode_pembelian = $request->input('id_order');
            $pembelianDetail->qty = $value->qty;
            $pembelianDetail->save();
        }
        Pembelian_temp::truncate();



        return redirect()->route('pembelian.index')->with('message', 'Request Pembelian Tersimpan!');
    }

    public function simpanTemp(Request $request)
    {
        $produk = new Pembelian_temp();
        $id_bahanbaku = $request->input('id_bahanbaku');
        $jenis = $request->input('jenis');
        $id_ukuran = $request->input('id_ukuran');
        $satuan = $request->input('satuan');
        $kode_pembelian = $request->input('kode_pembelian');
        $qty = $request->input('qty');

        $produk->id_bahanbaku = $id_bahanbaku;
        $produk->jenis = $jenis;
        $produk->id_ukuran = $id_ukuran;
        $produk->satuan = $satuan;
        $produk->kode_pembelian = $kode_pembelian;
        $produk->qty = $qty;
        $produk->save();
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
    public function updateTemp(Request $request)
    {
        $temp = new Pembelian_temp();
        $temp::where('id', $request->input('id'))
            ->update(['qty' => $request->input('qty')]);
        $json = 'bershasil';
        return response()->json($json);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produksi::find($id);
        $produk->delete();

        return redirect()->route('produk.index')->with('message', 'Berhasil Terhapus!');
    }
    public function dataTable(Request $request)
    {
        $tanggal =  $request->input('tanggal');
        $bb = Pembelian::orderBy('id','desc')->get();
        // join('pembelian_details', 'pembelians.kode', '=', 'pembelian_details.kode_pembelian')
        // ->where('penjualans.tanggal_order', 'LIKE', '%' . $tanggal . '%')
        return DataTables::of($bb)
            ->addIndexColumn()
            ->make();
    }
    public function dataTableTemp(Request $request)
    {
        $tanggal =  $request->input('tanggal');
        $bb = pembelian_temp::select(DB::raw('*,bahan_bakus.nama as nama_bahan,ukuran_bahans.nama as nama_ukuran,stok-qty as jumlah,pembelian_temps.id as id_temp'))
            // ->join('pembelian_temps', 'pembelians.kode', '=', 'pembelian_temps.kode_pembelian')
            ->join('bahan_bakus', 'bahan_bakus.id', '=', 'pembelian_temps.id_bahanbaku')
            ->join('ukuran_bahans', 'ukuran_bahans.id', '=', 'pembelian_temps.id_ukuran')
            ->get();
        return DataTables::of($bb)
            ->addIndexColumn()
            ->make();
    }
    public function dataTableDetail(Request $request)
    {
        $kode =  $request->input('kode');
        $bb = Pembelian_detail::select(DB::raw('*,bahan_bakus.nama as nama_bahan,ukuran_bahans.nama as nama_ukuran,qty'))
            ->join('pembelians', 'pembelians.kode', '=', 'pembelian_details.kode_pembelian')
            ->join('bahan_bakus', 'bahan_bakus.id', '=', 'pembelian_details.id_bahanbaku')
            ->join('ukuran_bahans', 'ukuran_bahans.id', '=', 'pembelian_details.id_ukuran')
            ->where('pembelian_details.kode_pembelian', '=', $kode)
            ->get();
        return DataTables::of($bb)
            ->addIndexColumn()
            ->make();
    }

    public function delete(Request $request)
    {
        $kode = $request->input('kode');
        $pembelian = Pembelian::where('kode', '=', $kode)->delete();
        $pembelianDetail = Pembelian_detail::where('kode_pembelian', '=', $kode)->delete();
        return response()->json([
            'title' => 'Deleted',
            'message' => 'Your imaginary file has been deleted!',
            'type'    => 'success',
        ]);
    }

    public function convertdate()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('dmy');
        return $date;
    }

    public function autonumber()
    {
        $count = Pembelian::all()->count();
        if ( $count == 0){
            return 'PPBB-1';
        }else{
            $count = $count + 1;
            return 'PPBB-' . $count;
        }
    }
    public function selectukuran(Request $request)
    {
        return UkuranBahan::where('nama', 'LIKE', '%' . request('q') . '%')
            ->where('id_bahanbaku', '=', $request->id)->paginate(10);
    }
}
