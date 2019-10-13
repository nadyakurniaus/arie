<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Produksi;
use App\Produksi_detail;
use App\UkuranBahan;
use App\ordered_item;
use DataTables;
use App\Pembelian_temp;
use App\Penjualan;
use App\Pembayaran;
use Carbon\Carbon;
use App\Design;

class ProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back.admin.produksi.index');
    }

    public function HasilProduksi()
    {
        return view('back.admin.produksi.hasil');
    }
    public function JadwalProduksi()
    {
        return view('back.admin.produksi.jadwal');
    }
    public function JadwalProduksi2()
    {
        return view('back.admin.produksi.jadwal2');
    }

    // class for supervisor
    public function listview()
    {
        return view('back.supervisor.produksi.index');
    }
    public function detail_chart()
    {
        return view('back.supervisor.produksi.detail-chart');
    }

    public function Hasil()
    {
        return view('back.supervisor.produksi.hasil');
    }
    public function Jadwal()
    {
        return view('back.supervisor.produksi.jadwal');
    }
    public function Finishing()
    {
        return view('back.supervisor.produksi.finishing');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kodeProduksi = ProduksiController::autonumber();
        return view('back.admin.produksi.create', ['nama' => $kodeProduksi]);
    }

    public function createSession(Request $request)
    {
        $tanggal = $request->tanggal_produksi;
        $metode = $request->metode;

        $request->session()->put('metode', 'otomatis');
        $request->session()->put('tanggal_produksi', $tanggal);
        return response()->json([
            'success' => true,
            'error'   => false,
            'message' => 'berhasil'
        ]);
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
            'kode_produksi' => 'required',


        ];
        $messages = [
            'kode_produksi.required' => ':attribute tidak boleh kosong',

        ];
        $request->validate($rules, $messages);

        $produk = new Produksi();
        $produk->kode_produksi = $request->kode_produksi;
        $produk->id_order = $request->id_order;
        $produk->desc = $request->keterangan;
        $produk->id_bahan_baku = $request->id_bahan;
        $produk->id_ukuran = $request->id_ukuran;
        $produk->qty = $request->qty;
        $produk->satuan = $request->satuan;
        $produk->proses = '2';
        $produk->status = 'Pending';
        $produk->save();

        return redirect()->route('produksi.index')->with('message', 'Produksi Tersimpan!');
    }

    public function ubahJadwal(Request $request)
    {
        $produk = new Produksi();
        $tanggal = $request->input('tanggal_produksi');
        $tanggalData = date('Y-m-d', strtotime($tanggal));
        $produk::where('id', $request->input('id_produksi'))
            ->update(['jadwal_produksi' => $tanggalData]);
        $json = 'bershasil';
        return response()->json($json);
    }

    public function isiOtomatis()
    {
        $bb = UkuranBahan::join('monitorings', 'ukuran_bahans.id', '=' ,'monitorings.id_ukuran')
            ->join('bahan_bakus', 'ukuran_bahans.id_bahanbaku', '=', 'bahan_bakus.id')
            ->whereColumn('ukuran_bahans.stok', '<=', 'minimum')
            ->select(DB::raw('ukuran_bahans.*,bahan_bakus.jenis'))
            ->get();
        // $bb = Produksi::join('penjualans', 'produksis.id_order', '=', 'penjualans.id')
        // ->join('ordered_items', 'ordered_items.id_order', '=', 'penjualans.id')
        // ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
        // ->join('bahan_bakus', 'produks.id_bahanbaku', '=', 'bahan_bakus.id')
        // ->join('ukuran_bahans', 'produks.id_ukuran', '=', 'ukuran_bahans.id')
        // ->where('ukuran_bahans.stok', '>=', '2')
        // ->select(DB::raw('DISTINCT kode_produksi,bahan_bakus.nama,ukuran_bahans.nama as nama_ukuran,ukuran_bahans.satuan as satuan,(select sum(jumlah) from ordered_items where id_order=produksis.id_order) as qty,(ukuran_bahans.stok - (select sum(jumlah) from ordered_items where id_order=produksis.id_order)) as jumlah, bahan_bakus.id as id_bahanbaku, jenis, ukuran_bahans.id as id_ukuran'))->get();
        $bahanbaku = $bb;
        foreach ($bahanbaku as $value) {
            $pembelianTemp = new Pembelian_temp;


            $kodePembelian = ProduksiController::generateKodePembelian();

            $pembelianTemp->id_bahanbaku = $value->id_bahanbaku;
            $pembelianTemp->jenis = $value->jenis;
            $pembelianTemp->id_ukuran = $value->id;
            $pembelianTemp->satuan = $value->satuan;
            $pembelianTemp->kode_pembelian = $kodePembelian;
            $pembelianTemp->qty = $value->stok;
            $pembelianTemp->save();
        }
        return redirect()->route('pembelian.create')->with('message', 'Produksi Tersimpan!');
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
        $produk = Produksi::find($id);
        $produk->delete();

        return redirect()->route('produk.index')->with('message', 'Berhasil Terhapus!');
    }
    public function dataTable(Request $request)
    {
        $tanggal =  $request->input('tanggal');
        $tanggalData = date('Y-m-d', strtotime($tanggal));
        $bb = Produksi::join('ordered_items', 'produksis.id_item', '=', 'ordered_items.id')
            ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
            ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
            ->join('bahan_bakus', 'produks.id_bahanbaku', '=', 'bahan_bakus.id')
            ->where('produksis.jadwal_produksi', 'LIKE', '%' . $tanggalData . '%')
            // ->where('produksis.jadwal_produksi', '!=', 'null')
            ->select(DB::raw('*,produksis.status as status_prod,bahan_bakus.nama as bahanbaku,produks.nama as namaproduk, ordered_items.id as ored_id, produksis.id as id_produksi '))->get();
        return DataTables::of($bb)
            ->addColumn('ukuran', function ($data) {
                return $data->ukuran->nama;
            })
            ->addColumn('satuan', function ($data) {
                return $data->ukuran->satuan;
            })
            ->addColumn('bahan', function ($data) {
                return $data->bahan_baku->nama;
            })
            ->addColumn('proses_detail', function($data){
                $design = Design::where('id_ordered','=',$data->ored_id)->first();
                $produksi = Produksi_detail::where('id_produksi' , '=' , $data->id_produksi)
                    ->where('type', '=', 'Master Plate')
                    ->first();
                $printing = Produksi_detail::where('id_produksi' , '=' , $data->id_produksi)
                    ->where('type', '=', 'printing')
                    ->first();
                $cutting = Produksi_detail::where('id_produksi' , '=' , $data->id_produksi)
                    ->where('type', '=', 'cuting')
                    ->first();
                $finishing = Produksi_detail::where('id_produksi' , '=' , $data->id_produksi)
                    ->where('type', '=', 'finishing')
                    ->first();
                if ($data->proses == 1) {
                    return '<div class ="row">'.
                    '<div class="checkbox-custom checkbox-default">' .
                        '<div class="col-md-4">'.
                            '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                            '<label for="Desain">Desain</label>'.
                        '</div>'.
                        '<div class="col-md-4">'.
                            $design->created_at->format('d/m/Y').
                        '</div>'.
                    '</div>'.
                '</div>'.
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Produksi">Produksi</label>' .
                    '</div>'.

                '</div>' .
            '</div>' .
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Printing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Produksi">Printing</label>' .
                    '</div>'.

                '</div>'.
            '</div>'.
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Cuting">Cuting</label>' .
                    '</div>'.

                '</div>' .
            '</div>' .
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Finishing">Finishing</label>' .
                    '</div>'.

                '</div>'.
            '</div>';
                } else if ($data->proses == 2) {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.

                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.

                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.

                            '</div>'.
                        '</div>';
                } else if ($data->proses == 0) {
                    return '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Desain">Desain</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Produksi" name="inputCheckboxRemember"  autocomplete="off" disabled>' .
                        '<label for="Produksi">Produksi</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Printing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Produksi">Printing</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Cuting">Cuting</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Finishing">Finishing</label>' .
                        '</div>';
                }
                else if ($data->proses == 3) {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $printing->qty->format('d/m/Y').
                                '</div>' .
                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember"  autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.
                            '</div>'.
                        '</div>';
                } else if ($data->proses == 4) {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $printing->qty->format('d/m/Y').
                                '</div>' .
                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $cutting->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.
                            '</div>'.
                        '</div>';
                }else {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $printing->qty->format('d/m/Y').
                                '</div>' .
                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $cutting->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $finishing->qty->format('d/m/Y').
                                '</div>'.
                            '</div>'.
                        '</div>';
                }

            })
            ->rawColumns(['proses_detail'])
            ->addIndexColumn()
            ->make();
    }

    public function dataTableJadwal(Request $request)
    {
        $tanggal =  $request->input('tanggal');
        $bb = Produksi::join('ordered_items', 'produksis.id_item', '=', 'ordered_items.id')
            ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
            ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
            ->join('bahan_bakus', 'produks.id_bahanbaku', '=', 'bahan_bakus.id')
            ->join('ukuran_bahans', 'ukuran_bahans.id', '=', 'produks.id_ukuran')
            // ->where('ordered_items.proses' ,'=', '1')
            // ->whereNull('produksis.jadwal_produksi')
            ->select(DB::raw('*,ordered_items.id as ored_id,bahan_bakus.nama as bahanbaku,produks.nama as namaproduk,produksis.id as id_produksi, ukuran_bahans.nama as nama_ukuran, produksis.status as progress,ordered_items.created_at as ca'))
            ->orderBy('id_produksi', 'desc')
            ->get();
        return DataTables::of($bb)
            ->addColumn('faktur_detail', function($data){
                return $data->no_faktur.'<br><a href="' . route('produk.fakturOrder', $data->id_produksi) .'"><i class="icon wb-share" aria-hidden="true"></i> Document_'.$data->no_faktur.'</a>';
            })
            ->addColumn('proses_detail', function($data){
                $design = Design::where('id_ordered','=',$data->ored_id)->first();
                $produksi = Produksi_detail::where('id_produksi' , '=' , $data->id_produksi)
                    ->where('type', '=', 'Master Plate')
                    ->first();
                $printing = Produksi_detail::where('id_produksi' , '=' , $data->id_produksi)
                    ->where('type', '=', 'printing')
                    ->first();
                $cutting = Produksi_detail::where('id_produksi' , '=' , $data->id_produksi)
                    ->where('type', '=', 'cuting')
                    ->first();
                $finishing = Produksi_detail::where('id_produksi' , '=' , $data->id_produksi)
                    ->where('type', '=', 'finishing')
                    ->first();
                if ($data->proses == 1) {
                    return '<div class ="row">'.
                    '<div class="checkbox-custom checkbox-default">' .
                        '<div class="col-md-4">'.
                            '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                            '<label for="Desain">Desain</label>'.
                        '</div>'.
                        '<div class="col-md-4">'.
                            $design->created_at->format('d/m/Y').
                        '</div>'.
                    '</div>'.
                '</div>'.
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Produksi">Produksi</label>' .
                    '</div>'.

                '</div>' .
            '</div>' .
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Printing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Produksi">Printing</label>' .
                    '</div>'.

                '</div>'.
            '</div>'.
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Cuting">Cuting</label>' .
                    '</div>'.

                '</div>' .
            '</div>' .
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Finishing">Finishing</label>' .
                    '</div>'.

                '</div>'.
            '</div>';
                } else if ($data->proses == 2) {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.

                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.

                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.

                            '</div>'.
                        '</div>';
                } else if ($data->proses == 0) {
                    return '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Desain">Desain</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Produksi" name="inputCheckboxRemember"  autocomplete="off" disabled>' .
                        '<label for="Produksi">Produksi</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Printing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Produksi">Printing</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Cuting">Cuting</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Finishing">Finishing</label>' .
                        '</div>';
                }
                else if ($data->proses == 3) {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $printing->qty->format('d/m/Y').
                                '</div>' .
                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember"  autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.
                            '</div>'.
                        '</div>';
                } else if ($data->proses == 4) {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $printing->qty->format('d/m/Y').
                                '</div>' .
                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $cutting->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.
                            '</div>'.
                        '</div>';
                }else {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $printing->qty->format('d/m/Y').
                                '</div>' .
                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $cutting->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $finishing->qty->format('d/m/Y').
                                '</div>'.
                            '</div>'.
                        '</div>';
                }

            })
            ->rawColumns(['faktur_detail','proses_detail'])
            ->addIndexColumn()
            ->make();
    }
    public function dataTableJadwal2(Request $request)
    {
        $tanggal =  $request->input('tanggal');
        $bb = Produksi::join('ordered_items', 'produksis.id_item', '=', 'ordered_items.id')
            ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
            ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
            ->join('bahan_bakus', 'produks.id_bahanbaku', '=', 'bahan_bakus.id')
            ->join('ukuran_bahans', 'ukuran_bahans.id', '=', 'produks.id_ukuran')
            // ->where('ordered_items.proses' ,'=', '1')
            ->whereNull('produksis.jadwal_produksi')
            ->select(DB::raw('*,ordered_items.id as ored_id,bahan_bakus.nama as bahanbaku,produks.nama as namaproduk,produksis.id as id_produksi, ukuran_bahans.nama as nama_ukuran, produksis.status as progress,ordered_items.created_at as ca'))
            ->orderBy('id_produksi', 'desc')
            ->get();
        return DataTables::of($bb)
            ->addColumn('faktur_detail', function($data){
                return $data->no_faktur.'<br><a href="' . route('produk.fakturOrder', $data->id_produksi) .'"><i class="icon wb-share" aria-hidden="true"></i> Document_'.$data->no_faktur.'</a>';
            })
            ->addColumn('proses_detail', function($data){
                $design = Design::where('id_ordered','=',$data->ored_id)->first();
                $produksi = Produksi_detail::where('id_produksi' , '=' , $data->id_produksi)
                    ->where('type', '=', 'Master Plate')
                    ->first();
                $printing = Produksi_detail::where('id_produksi' , '=' , $data->id_produksi)
                    ->where('type', '=', 'printing')
                    ->first();
                $cutting = Produksi_detail::where('id_produksi' , '=' , $data->id_produksi)
                    ->where('type', '=', 'cuting')
                    ->first();
                $finishing = Produksi_detail::where('id_produksi' , '=' , $data->id_produksi)
                    ->where('type', '=', 'finishing')
                    ->first();
                if ($data->proses == 1) {
                    return '<div class ="row">'.
                    '<div class="checkbox-custom checkbox-default">' .
                        '<div class="col-md-4">'.
                            '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                            '<label for="Desain">Desain</label>'.
                        '</div>'.
                        '<div class="col-md-4">'.
                            $design->created_at->format('d/m/Y').
                        '</div>'.
                    '</div>'.
                '</div>'.
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Produksi">Produksi</label>' .
                    '</div>'.

                '</div>' .
            '</div>' .
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Printing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Produksi">Printing</label>' .
                    '</div>'.

                '</div>'.
            '</div>'.
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Cuting">Cuting</label>' .
                    '</div>'.

                '</div>' .
            '</div>' .
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Finishing">Finishing</label>' .
                    '</div>'.

                '</div>'.
            '</div>';
                } else if ($data->proses == 2) {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.

                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.

                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.

                            '</div>'.
                        '</div>';
                } else if ($data->proses == 0) {
                    return '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Desain">Desain</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Produksi" name="inputCheckboxRemember"  autocomplete="off" disabled>' .
                        '<label for="Produksi">Produksi</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Printing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Produksi">Printing</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Cuting">Cuting</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Finishing">Finishing</label>' .
                        '</div>';
                }
                else if ($data->proses == 3) {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $printing->qty->format('d/m/Y').
                                '</div>' .
                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember"  autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.
                            '</div>'.
                        '</div>';
                } else if ($data->proses == 4) {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $printing->qty->format('d/m/Y').
                                '</div>' .
                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $cutting->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.
                            '</div>'.
                        '</div>';
                }else {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $printing->qty->format('d/m/Y').
                                '</div>' .
                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $cutting->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $finishing->qty->format('d/m/Y').
                                '</div>'.
                            '</div>'.
                        '</div>';
                }

            })
            ->rawColumns(['faktur_detail','proses_detail'])
            ->addIndexColumn()
            ->make();
    }

    public function dataTableBahan(Request $request)
    {
        $tanggal =  $request->input('tanggal');
        $tanggalData = date('Y-m-d', strtotime($tanggal));
        $bb = Produksi::join('ordered_items', 'produksis.id_item', '=', 'ordered_items.id')
            ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
            ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
            ->join('bahan_bakus', 'produks.id_bahanbaku', '=', 'bahan_bakus.id')
            ->join('ukuran_bahans', 'produks.id_ukuran', '=', 'ukuran_bahans.id')
            ->where('produksis.jadwal_produksi', 'LIKE', '%' . $tanggalData . '%')
            ->select(DB::raw('DISTINCT kode_produksi,bahan_bakus.nama,ukuran_bahans.nama as nama_ukuran,ukuran_bahans.satuan as satuan,(select sum(jumlah) from ordered_items where id_order=penjualans.id) as qty,(ukuran_bahans.stok - (select sum(jumlah) from ordered_items where id_order=penjualans.id)) as jembut'))->limit(1)->get();
        return DataTables::of($bb)
            ->addIndexColumn()
            ->make();
    }

    public function convertdate()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('dmy');
        return $date;
    }

    public function autonumber()
    {
        $count = Produksi::all()->count();
        if ( $count == 0){
            return 'PRDKS-1';
        }else{
            $count = $count + 1;
            return 'PRDKS-' . $count;
        }
    }


    public function generateKodePembelian()
    {
        $count = Pembelian::all()->count();
        if ( $count == 0){
            return 'PPBB-1';
        }else{
            $count = $count + 1;
            return 'PPBB-' . $count;
        }
    }


    //supervisor area
    public function dtProduksiSPV(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $tanggalData = date('Y-m-d',strtotime($tanggal));
        $bb = Produksi::join('ordered_items', 'produksis.id_item', '=', 'ordered_items.id')
            ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
            ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
            ->join('bahan_bakus', 'produks.id_bahanbaku', '=', 'bahan_bakus.id')
            ->join('ukuran_bahans', 'ukuran_bahans.id', '=', 'produks.id_ukuran')
            ->where('produksis.jadwal_produksi', 'LIKE', '%' . $tanggalData. '%')
            ->where('ordered_items.proses', '>', '0')
            ->select(DB::raw("*,IF(ordered_items.proses<=1 or produksis.status ='pending', 'aktif', 'nonaktif') as button,ordered_items.id as ored_id,bahan_bakus.nama as bahanbaku,produks.nama as namaproduk,produksis.id as id_produksi, ukuran_bahans.nama as nama_ukuran,produksis.status as progress, ordered_items.id as idOrder"))
            ->orderBy('ored_id','desc')
            ->get();
        return DataTables::of($bb)
            ->addColumn('faktur_detail', function($data){
                return $data->no_faktur.'<br><a href="' . route('produk.fakturOrder', $data->id_produksi) .'"><i class="icon wb-share" aria-hidden="true"></i> Document_'.$data->no_faktur.'</a>';
            })
            ->addColumn('proses_detail', function($data){
                $design = Design::where('id_ordered','=',$data->ored_id)->first();
                $produksi = Produksi_detail::where('id_produksi' , '=' , $data->id_produksi)
                    ->where('type', '=', 'Master Plate')
                    ->first();
                $printing = Produksi_detail::where('id_produksi' , '=' , $data->id_produksi)
                    ->where('type', '=', 'printing')
                    ->first();
                $cutting = Produksi_detail::where('id_produksi' , '=' , $data->id_produksi)
                    ->where('type', '=', 'cuting')
                    ->first();
                $finishing = Produksi_detail::where('id_produksi' , '=' , $data->id_produksi)
                    ->where('type', '=', 'finishing')
                    ->first();
                if ($data->proses == 1) {
                    return '<div class ="row">'.
                    '<div class="checkbox-custom checkbox-default">' .
                        '<div class="col-md-4">'.
                            '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                            '<label for="Desain">Desain</label>'.
                        '</div>'.
                        '<div class="col-md-4">'.
                            $design->created_at->format('d/m/Y').
                        '</div>'.
                    '</div>'.
                '</div>'.
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Produksi">Produksi</label>' .
                    '</div>'.

                '</div>' .
            '</div>' .
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Printing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Produksi">Printing</label>' .
                    '</div>'.

                '</div>'.
            '</div>'.
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Cuting">Cuting</label>' .
                    '</div>'.

                '</div>' .
            '</div>' .
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Finishing">Finishing</label>' .
                    '</div>'.

                '</div>'.
            '</div>';
                } else if ($data->proses == 2) {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.

                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.

                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.

                            '</div>'.
                        '</div>';
                } else if ($data->proses == 0) {
                    return '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Desain">Desain</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Produksi" name="inputCheckboxRemember"  autocomplete="off" disabled>' .
                        '<label for="Produksi">Produksi</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Printing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Produksi">Printing</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Cuting">Cuting</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Finishing">Finishing</label>' .
                        '</div>';
                }
                else if ($data->proses == 3) {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $printing->qty->format('d/m/Y').
                                '</div>' .
                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember"  autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.
                            '</div>'.
                        '</div>';
                } else if ($data->proses == 4) {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $printing->qty->format('d/m/Y').
                                '</div>' .
                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $cutting->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.
                            '</div>'.
                        '</div>';
                }else {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $printing->qty->format('d/m/Y').
                                '</div>' .
                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $cutting->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $finishing->qty->format('d/m/Y').
                                '</div>'.
                            '</div>'.
                        '</div>';
                }

            })
            ->rawColumns(['faktur_detail','proses_detail'])
            ->addIndexColumn()
            ->make();
    }

    public function getInfo(Request $request)
    {
        $bb = Produksi_detail::where('id_produksi', '=', $request->input('id_produksi'))
        ->get();
        return $bb;
    }
    public function dtProduksiSPV2(Request $request)
    {
        $tanggal =  $request->input('tanggal');
        $bb = Produksi::join('ordered_items', 'produksis.id_item', '=', 'ordered_items.id')
            ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
            ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
            ->join('bahan_bakus', 'produks.id_bahanbaku', '=', 'bahan_bakus.id')
            ->join('ukuran_bahans', 'ukuran_bahans.id', '=', 'produks.id_ukuran')
            ->where('produksis.jadwal_produksi', 'LIKE', '%' . $tanggal . '%')
            ->where('ordered_items.proses', '>', '3')
            // ->whereNull('produksis.jadwal_produksi')
            ->select(DB::raw("*,IF(ordered_items.proses<=1 or produksis.status ='pending', 'aktif', 'nonaktif') as button,ordered_items.id as ored_id,bahan_bakus.nama as bahanbaku,produks.nama as namaproduk,produksis.id as id_produksi, ukuran_bahans.nama as nama_ukuran,produksis.status as progress, ordered_items.id as idOrder"))->get();
        return DataTables::of($bb)
            ->addColumn('faktur_detail', function($data){
                return $data->no_faktur.'<br><a href="' . route('produk.fakturOrder', $data->id_produksi) .'"><i class="icon wb-share" aria-hidden="true"></i> Document_'.$data->no_faktur.'</a>';
            })
            ->rawColumns(['faktur_detail'])
            ->addIndexColumn()
            ->make();
    }

    public function prosesProduksi(Request $request)
    {
        $produk = new Produksi();
        $item = new ordered_item();
        if ($request->input('jadwal_produksi') == '') {
            $produk::where('id', $request->input('id_produksi'))
                ->update(['status' => 'tidak ada status']);
            $item::where('id', $request->input('id_produksi'))
                ->update(['proses' => 2]);
        } else {
            $produk::where('id', $request->input('id_produksi'))
                ->update(['status' => 'tidak ada status', 'jadwal_produksi' => $request->input('jadwal_produksi')]);
            $item::where('id', $request->input('id_produksi'))
                ->update(['proses' => 2]);
        }
        $order = new ordered_item();
        $updatestok = new UkuranBahan();
        $updatestok::where('id', $request->input('id_ukuran'))
            ->update(['stok' => $request->input('stok') - $request->input('jumlah')]);
        $json = 'bershasil';
        return response()->json($json);
    }
    public function prosesFinishing(Request $request)
    {
        $produk = new Produksi();
        $item = new ordered_item();
        if ($request->input('jadwal_produksi') == '') {
            $produk::where('id', $request->input('id_produksi'))
                ->update(['status' => 'Done']);
            $item::where('id', $request->input('id_produksi'))
                ->update(['proses' => 5]);
        } else {
            $produk::where('id', $request->input('id_produksi'))
                ->update(['status' => 'Done', 'jadwal_produksi' => $request->input('jadwal_produksi')]);
            $item::where('id', $request->input('id_produksi'))
                ->update(['proses' => 5]);
        }
        $order = new ordered_item();
        $updatestok = new UkuranBahan();
        $updatestok::where('id', $request->input('id_ukuran'))
            ->update(['stok' => $request->input('stok') - $request->input('jumlah')]);
        $json = 'bershasil';
        return response()->json($json);
    }

    public function updateStatus(Request $request)
    {
        $produk = new Produksi();
        $produk::where('id', $request->input('id_produksi'))
            ->update(['status' => $request->input('status')]);
        $json = 'bershasil';
        return response()->json($json);
    }
    public function tidakAdaStatus(Request $request)
    {
        $tanggal =  $request->input('tanggal');
        $tanggalData = date('Y-m-d', strtotime($tanggal));
        $count = Produksi::join('ordered_items', 'produksis.id_item', '=', 'ordered_items.id')
            ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
            ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
            ->join('bahan_bakus', 'produks.id_bahanbaku', '=', 'bahan_bakus.id')
            ->where('produksis.jadwal_produksi', 'LIKE', '%' . $tanggalData . '%')
            ->where('produksis.status', '=', 'Tidak ada status')
            ->whereNotNull('produksis.jadwal_produksi')
            ->select(DB::raw('*,bahan_bakus.nama as bahanbaku,produks.nama as namaproduk,produksis.id as id_prod,produksis.status as progress'))->get();

            $counter = $count->count();

        return response()->json($counter);
    }
    public function pending(Request $request)
    {
        $tanggal =  $request->input('tanggal');
        $tanggalData = date('Y-m-d', strtotime($tanggal));
        $count = Produksi::join('ordered_items', 'produksis.id_item', '=', 'ordered_items.id')
            ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
            ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
            ->join('bahan_bakus', 'produks.id_bahanbaku', '=', 'bahan_bakus.id')
            ->where('produksis.jadwal_produksi', 'LIKE', '%' . $tanggalData . '%')
            ->where('produksis.status', '=', 'pending')
            ->whereNotNull('produksis.jadwal_produksi')
            ->select(DB::raw('*,bahan_bakus.nama as bahanbaku,produks.nama as namaproduk,produksis.id as id_prod,produksis.status as progress'))->get();

            $counter = $count->count();

        return response()->json($counter);
    }
    public function done(Request $request)
    {
        $tanggal =  $request->input('tanggal');
        $tanggalData = date('Y-m-d', strtotime($tanggal));
        $count = Produksi::join('ordered_items', 'produksis.id_item', '=', 'ordered_items.id')
            ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
            ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
            ->join('bahan_bakus', 'produks.id_bahanbaku', '=', 'bahan_bakus.id')
            ->where('produksis.jadwal_produksi', 'LIKE', '%' . $tanggalData . '%')
            ->where('produksis.status', '=', 'done')
            ->whereNotNull('produksis.jadwal_produksi')
            ->select(DB::raw('*,bahan_bakus.nama as bahanbaku,produks.nama as namaproduk,produksis.id as id_prod,produksis.status as progress'))->get();

            $counter = $count->count();

        return response()->json($counter);
    }

    public function simpanDetail(Request $request)
    {
        $produk = new Produksi_detail();
        $tanggal = $request->qty;
        $tanggalData = date('Y-m-d', strtotime($tanggal));
        $produk->id_produksi = $request->id;
        $produk->qty = $tanggalData;
        $produk->type = $request->type;
        $produk->save();
        //detail
        $item = new ordered_item();
        $item::where('id', $request->input('primary'))
        ->update(['proses' => $request->input('status')]);
        $produksi = new Produksi();
        $produksi::where('id', $request->id)
        ->update(['status' => 'pending']);
        //stok
        $updatestok = new UkuranBahan();
        $updatestok::where('id', $request->input('id_ukuran'))
            ->update(['stok' => $request->input('stok') - $request->input('jumlah')]);
        $json = 'bershasil';
        return response()->json($json);
    }

    public function dtMonitoringSPV(Request $request)
    {
        $tanggal =  $request->input('tanggal');
        $tanggalData = date('Y-m-d', strtotime($tanggal));
        $bb = Produksi::join('ordered_items', 'produksis.id_item', '=', 'ordered_items.id')
            ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
            ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
            ->join('bahan_bakus', 'produks.id_bahanbaku', '=', 'bahan_bakus.id')
            ->where('produksis.jadwal_produksi', 'LIKE', '%' . $tanggalData . '%')
            ->where('ordered_items.proses', '>=', '1')
            ->whereNotNull('produksis.jadwal_produksi')
            ->select(DB::raw('*,bahan_bakus.nama as bahanbaku,produks.nama as namaproduk,produksis.id as id_prod,produksis.status as progress, ordered_items.id as ored_id'))->get();
        return DataTables::of($bb)
            ->addColumn('ukuran', function ($data) {
                return $data->ukuran->nama;
            })
            ->addColumn('satuan', function ($data) {
                return $data->ukuran->satuan;
            })
            ->addColumn('bahan', function ($data) {
                return $data->bahan_baku->nama;
            })
            ->addColumn('proses_detail', function($data){
                $design = Design::where('id_ordered','=',$data->ored_id)->first();
                $produksi = Produksi_detail::where('id_produksi' , '=' , $data->id_prod)
                    ->where('type', '=', 'Master Plate')
                    ->first();
                $printing = Produksi_detail::where('id_produksi' , '=' , $data->id_prod)
                    ->where('type', '=', 'printing')
                    ->first();
                $cutting = Produksi_detail::where('id_produksi' , '=' , $data->id_prod)
                    ->where('type', '=', 'cuting')
                    ->first();
                $finishing = Produksi_detail::where('id_produksi' , '=' , $data->id_prod)
                    ->where('type', '=', 'finishing')
                    ->first();
                if ($data->proses == 1) {
                    return '<div class ="row">'.
                    '<div class="checkbox-custom checkbox-default">' .
                        '<div class="col-md-4">'.
                            '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                            '<label for="Desain">Desain</label>'.
                        '</div>'.
                        '<div class="col-md-4">'.
                            $design->created_at->format('d/m/Y').
                        '</div>'.
                    '</div>'.
                '</div>'.
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Produksi">Produksi</label>' .
                    '</div>'.

                '</div>' .
            '</div>' .
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Printing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Produksi">Printing</label>' .
                    '</div>'.

                '</div>'.
            '</div>'.
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Cuting">Cuting</label>' .
                    '</div>'.

                '</div>' .
            '</div>' .
            '<div class ="row">'.
                '<div class="checkbox-custom checkbox-default">' .
                    '<div class="col-md-4">'.
                        '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Finishing">Finishing</label>' .
                    '</div>'.

                '</div>'.
            '</div>';
                } else if ($data->proses == 2) {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.

                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.

                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.

                            '</div>'.
                        '</div>';
                } else if ($data->proses == 0) {
                    return '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Desain">Desain</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Produksi" name="inputCheckboxRemember"  autocomplete="off" disabled>' .
                        '<label for="Produksi">Produksi</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Printing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Produksi">Printing</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Cuting">Cuting</label>' .
                        '</div>' .
                        '<div class="checkbox-custom checkbox-default">' .
                        '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                        '<label for="Finishing">Finishing</label>' .
                        '</div>';
                }
                else if ($data->proses == 3) {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $printing->qty->format('d/m/Y').
                                '</div>' .
                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember"  autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.
                            '</div>'.
                        '</div>';
                } else if ($data->proses == 4) {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $printing->qty->format('d/m/Y').
                                '</div>' .
                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $cutting->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.
                            '</div>'.
                        '</div>';
                }else {
                    return '<div class ="row">'.
                                '<div class="checkbox-custom checkbox-default">' .
                                    '<div class="col-md-4">'.
                                        '<input type="checkbox" id="Desain" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                        '<label for="Desain">Desain</label>'.
                                    '</div>'.
                                    '<div class="col-md-4">'.
                                        $design->created_at->format('d/m/Y').
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Produksi" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Produksi</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $produksi->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Printing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Produksi">Printing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $printing->qty->format('d/m/Y').
                                '</div>' .
                            '</div>'.
                        '</div>'.
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Cuting" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Cuting">Cuting</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $cutting->qty->format('d/m/Y').
                                '</div>'.
                            '</div>' .
                        '</div>' .
                        '<div class ="row">'.
                            '<div class="checkbox-custom checkbox-default">' .
                                '<div class="col-md-4">'.
                                    '<input type="checkbox" id="Finishing" name="inputCheckboxRemember" checked="" autocomplete="off" disabled>' .
                                    '<label for="Finishing">Finishing</label>' .
                                '</div>'.
                                '<div class="col-md-4">'.
                                    $finishing->qty->format('d/m/Y').
                                '</div>'.
                            '</div>'.
                        '</div>';
                }

            })
            ->rawColumns(['proses_detail'])
            ->addIndexColumn()
            ->make();
    }

    public function dtDetail(Request $request)
    {
        $bulan =  $request->input('month');
        $bb = Produksi::join('ordered_items', 'produksis.id_item', '=', 'ordered_items.id')
            ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
            ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
            ->join('bahan_bakus', 'produks.id_bahanbaku', '=', 'bahan_bakus.id')
            ->whereMonth('produksis.jadwal_produksi', $bulan)
            ->where('ordered_items.proses', '>=', '1')
            ->select(DB::raw('*,bahan_bakus.nama as bahanbaku,produks.nama as namaproduk,produksis.id as id_prod,produksis.status as progress'))->get();
        return DataTables::of($bb)
            ->addColumn('ukuran', function ($data) {
                return $data->ukuran->nama;
            })
            ->addColumn('satuan', function ($data) {
                return $data->ukuran->satuan;
            })
            ->addColumn('bahan', function ($data) {
                return $data->bahan_baku->nama;
            })
            ->addIndexColumn()
            ->make();
    }
    public function fakturOrder($id){
        $penjualan = Penjualan::find($id);
        $pembayaran = Pembayaran::where('id_order', '=', $id)->get();
        $item = ordered_item::where('id_order', '=', $id)->get();
        return view ('back.supervisor.produksi.faktur', compact('penjualan','pembayaran','item'));
    }
}
