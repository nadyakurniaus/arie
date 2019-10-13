<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Produksi_detail;
use App\ordered_item;
use App\Design;
use App\Produksi;
use DataTables;

class FinishingController extends Controller
{
    public function simpanDetail(Request $request)
    {
        $produk = new Produksi_detail();
        $tanggal = $request->qty;
        $tanggalData = date('Y-m-d', strtotime($tanggal));
        $produk->id_produksi = $request->id;
        $produk->qty = $tanggalData;
        $produk->type = $request->type;
        $produk->save();

        $item = new ordered_item();
        $item::where('id', $request->input('primary'))
        ->update(['proses' => $request->input('status')]);
        $produksi = new Produksi();
        $produksi::where('id','=', $request->id)
        ->update(['status' => 'Done']);

        $json = 'bershasil';
        return response()->json($json);
    }

    public function dtProduksiFSG(Request $request)
    {
        $tanggal =  $request->input('tanggal');
        $tanggalData = date('Y-m-d', strtotime($tanggal));
        $bb = Produksi::join('ordered_items', 'produksis.id_item', '=', 'ordered_items.id')
            ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
            ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
            ->join('bahan_bakus', 'produks.id_bahanbaku', '=', 'bahan_bakus.id')
            ->join('ukuran_bahans', 'ukuran_bahans.id', '=', 'produks.id_ukuran')
            ->where('produksis.jadwal_produksi', 'LIKE', '%' . $tanggalData . '%')
            ->where('ordered_items.proses', '>', '0')
            ->select(DB::raw("*,IF(ordered_items.proses<=1 or produksis.status ='pending', 'aktif', 'nonaktif') as button,ordered_items.id as ored_id,bahan_bakus.nama as bahanbaku,produks.nama as namaproduk,produksis.id as id_produksi, ukuran_bahans.nama as nama_ukuran,produksis.status as progress, ordered_items.id as idOrder,ordered_items.created_at as ca"))
            ->orderBy('ca', 'desc')->get();
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
    public function dtProduksiFSG2(Request $request)
    {
        $tanggal =  $request->input('tanggal');
        $tanggalData = date('Y-m-d', strtotime($tanggal));
        $bb = Produksi::join('ordered_items', 'produksis.id_item', '=', 'ordered_items.id')
            ->join('penjualans', 'ordered_items.id_order', '=', 'penjualans.id')
            ->join('produks', 'ordered_items.id_produk', '=', 'produks.id')
            ->join('bahan_bakus', 'produks.id_bahanbaku', '=', 'bahan_bakus.id')
            ->join('ukuran_bahans', 'ukuran_bahans.id', '=', 'produks.id_ukuran')
            // ->where('produksis.jadwal_produksi', 'LIKE', '%' . $tanggalData . '%')
            ->where('ordered_items.proses', '=', '4')
            ->select(DB::raw("*,IF(ordered_items.proses<=1 or produksis.status ='pending', 'aktif', 'nonaktif') as button,ordered_items.id as ored_id,bahan_bakus.nama as bahanbaku,produks.nama as namaproduk,produksis.id as id_produksi, ukuran_bahans.nama as nama_ukuran,produksis.status as progress, ordered_items.id as idOrder,ordered_items.created_at as ca"))
            ->orderBy('id_produksi', 'desc')->get();
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
}
